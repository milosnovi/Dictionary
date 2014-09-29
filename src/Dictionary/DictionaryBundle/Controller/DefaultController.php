<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\History;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Entity\WordRepository;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();

		/** @var $historyRepository HistoryRepository */
		$historyRepository = $em->getRepository('DictionaryBundle:History');

		$historyResult = array();
		$resultHits = array();

		$histories = $historyRepository->getLatestSearched($user);
		$englishIds = array();
		foreach($histories as $history) {
			$englishIds[] = $history->getWord()->getId();
			$historyResult[$history->getWord()->getName()] = array();
		}
		$historyByHits = $historyRepository->getSearchedByHits($user);

		foreach($historyByHits as $hit) {
			if (!in_array($hit->getWord()->getId(), $englishIds)) {
				$englishIds[] = $hit->getWord()->getId();
			}
			$resultHits[$hit->getWord()->getName()] = array(
				'hits' => $hit->getHits()
			);
		}

		/** @var  $eng2srbRepository Eng2srbRepository*/
		$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->getEnglishTranslations($englishIds);

		/** @var $history History*/
		foreach($results as $result) {

			/** @var  $serbianTransations Word */
			$serbianTransations = $result->getSrb();

			$index = Word::wordType2String($serbianTransations->getWordType());
			if(!isset($historyResult[$result->getEng()->getName()]['translations'][$index])) {
				$historyResult[$result->getEng()->getName()]['translations'][$index] = array();
				$resultHits[$result->getEng()->getName()]['translations'][$index] = array();
			}
			$historyResult[$result->getEng()->getName()]['translations'][$index][] = $result->getSrb()->getName();
			$resultHits[$result->getEng()->getName()]['translations'][$index][] = $result->getSrb()->getName();
		}
		$word = strtolower($request->get('word'));
        return array(
			'latestSearch'	=> isset($historyResult[$word]) ? $historyResult[$word] : false,
			'latestWord'	=> $word,
			'histories' 	=> $historyResult,
			'historyHits' 	=> $resultHits
		);
    }

	/**
	 * @Route("/translate", name="_translate")
	 * @Template("DictionaryBundle:Default:index.html.twig")
	 */
	public function matchAction(Request $request)
	{
		$word = strtolower($request->get('q'));
		if (empty($word)) {
			return $this->redirect($this->generateUrl('_home'));
		}

		$user = $this->getUser();

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');
		$success = $translationManager->translate($word, $user);
		if(!$success) {
			$success = $translationManager->translateFromService($word, $user);
		}

		if (!$success) {
			$this->get('session')->getFlashBag()->add(
				'notice',
				'No results'
			);
		}

		return $this->redirect($this->generateUrl('_home', array('word' => $word)));
	}

	/**
	 *  @Route("/test", name="_translate1")
	 */
	public function testAction(Request $request) {

		$word = strtolower($request->get('q'));
		if (empty($word)) {
			return $this->redirect($this->generateUrl('_home'));
		}

		/** @var $wordRepository WordRepository */
		$wordRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Word');
		$english = $wordRepository->findOneBy(array(
			'name' => $word,
			'type' => Word::WORD_ENGLISH
		));

		$em = $this->getDoctrine()->getManager();
		if(!$english) {
			/** @var  $english Word */
			$english = new Word();
			$english->setName($word);
			$english->settype(Word::WORD_ENGLISH);
			$english->setCreated(new \DateTime());
			$english->setUpdated(new \DateTime());
			$em->persist($english);
			$em->flush();
		}

		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://translate.google.com/translate_a/t?client=p&sl=auto&tl=sr&hl=en&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&dt=at&dt=sw&ie=UTF-8&oe=UTF-8&oc=1&otf=1&ssel=0&tsel=0&q=' . $word,
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		$resp = curl_exec($curl);
		$output = json_decode($resp);
		if ($output->dict) {
			$dictionary = $output->dict;
			foreach ($dictionary as $dict) {
				if ('noun' == $dict->pos) {
					$type = Word::WORD_TYPE_NOUN;
				} else if ('verb' == $dict->pos) {
					$type = Word::WORD_TYPE_VERB;
				} else if ('adverb' == $dict->pos) {
					$type = Word::WORD_TYPE_ADV;
				} else if ('adjective' == $dict->pos) {
					$type = Word::WORD_TYPE_ADJ;
				} else {
					continue;
				}

				$t = \Transliterator::create('Serbian-Latin/BGN');
				foreach ($dict->terms as $relevance => $term) {
					$serbianTranslation = $t->transliterate($term);
					/** @var $serbian Word */
					$serbian = $wordRepository->findOneBy(array(
						'name' => $serbianTranslation,
						'type' => Word::WORD_SERBIAN
					));
					if (!$serbian) {
						/** @var  $english Word */
						$serbian = new Word();
						$serbian->setName($serbianTranslation);
						$serbian->settype(Word::WORD_SERBIAN);
						$serbian->setWordType($type);
						$serbian->setCreated(new \DateTime());
						$serbian->setUpdated(new \DateTime());
					} else {
						$serbian->setWordType($type);
					}
					$em->persist($serbian);
					$em->flush();

					/** @var $eng2srbRepository Eng2srbRepository */
					$eng2srbRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Eng2srb');
					$eng2SrbItem = $eng2srbRepository->createQueryBuilder('eng2srb')
						->select('eng2srb')
						->innerJoin('eng2srb.eng', 'english')
						->innerJoin('eng2srb.srb', 'serbian')
						->where('english = :english')
						->andWhere('eng2srb.direction = :direction')
						->andWhere('serbian = :serbian')
						->andWhere('english.type = :englishType')
						->andWhere('serbian.type = :serbianType')
						->setParameters(array(
							'english' => $english,
							'serbian' => $serbian,
							'englishType' => Word::WORD_ENGLISH,
							'serbianType' => Word::WORD_SERBIAN,
							'direction' => Eng2srb::ENG_2_SRB
						))
						->getQuery()
						->getOneOrNullResult();

					if (empty($eng2SrbItem)) {
						/** @var  $eng2SrbItem Eng2srb */
						$eng2SrbItem = new Eng2srb();
						$eng2SrbItem->setEng($english);
						$eng2SrbItem->setSrb($serbian);
						$eng2SrbItem->setRelevance($relevance + 1);
						$eng2SrbItem->setDirection(Eng2srb::ENG_2_SRB);
						$eng2SrbItem->setCreated(new \DateTime());
						$eng2SrbItem->setUpdated(new \DateTime());
						$em->persist($eng2SrbItem);
						$em->flush();
					} else {
						$eng2SrbItem->setRelevance($relevance + 1);
						$eng2SrbItem->setDirection(Eng2srb::ENG_2_SRB);
						$em->persist($eng2SrbItem);
						$em->flush();
					}

					$englishTranslations = $dict->entry[$relevance];
					foreach ($englishTranslations->reverse_translation as $revertTraRelevance => $englishTran) {
						$englishReversTrans = $wordRepository->findOneBy(array(
							'name' => $englishTran,
							'type' => Word::WORD_ENGLISH
						));

						if (!$englishReversTrans) {
							/** @var  $english Word */
							$englishReversTrans = new Word();
							$englishReversTrans->setName($englishTran);
							$englishReversTrans->settype(Word::WORD_ENGLISH);
							$englishReversTrans->setCreated(new \DateTime());
							$englishReversTrans->setUpdated(new \DateTime());
							$em->persist($englishReversTrans);
							$em->flush();
						}

						$eng2SrbItem = $eng2srbRepository->createQueryBuilder('eng2srb')
							->select('eng2srb')
							->innerJoin('eng2srb.eng', 'english')
							->innerJoin('eng2srb.srb', 'serbian')
							->where('english = :english')
							->andWhere('eng2srb.direction = :direction')
							->andWhere('serbian = :serbian')
							->andWhere('english.type = :englishType')
							->andWhere('serbian.type = :serbianType')
							->setParameters(array(
								'english' => $englishReversTrans,
								'serbian' => $serbian,
								'englishType' => Word::WORD_ENGLISH,
								'serbianType' => Word::WORD_SERBIAN,
								'direction' => Eng2srb::SRB_2_ENG,
							))
							->getQuery()
							->getOneOrNullResult();

						if (empty($eng2SrbItem)) {
							/** @var  $eng2SrbItem Eng2srb */
							$eng2SrbItem = new Eng2srb();
							$eng2SrbItem->setEng($englishReversTrans);
							$eng2SrbItem->setSrb($serbian);
							$eng2SrbItem->setRelevance($revertTraRelevance + 1);
							$eng2SrbItem->setDirection(Eng2srb::SRB_2_ENG);
							$eng2SrbItem->setCreated(new \DateTime());
							$eng2SrbItem->setUpdated(new \DateTime());
							$em->persist($eng2SrbItem);
							$em->flush();
						} else {
							$eng2SrbItem->setRelevance($revertTraRelevance + 1);
							$eng2SrbItem->setDirection(Eng2srb::SRB_2_ENG);
							$em->persist($eng2SrbItem);
							$em->flush();
						}
					}
				}
			}
			$user = $this->getUser();
			/** @var $historyRepository HistoryRepository */
			$historyRepository = $em->getRepository('DictionaryBundle:History');
			/** @var  $historyLog History */
			$historyLog = $historyRepository->findOneBy(
				array(
					'word' => $english,
					'user' => $user
				)
			);

			if ($historyLog) {
				$historyLog->setLastSearch(new \DateTime());
				$hits = (int)$historyLog->getHits() + 1;
				$historyLog->setHits($hits);
				$em->flush();
			} else {
				/** @var $history History */
				$historyLog = new History();
				$historyLog->setWord($english);
				$historyLog->setUser($user);
				$historyLog->setHits(1);
				$historyLog->setLastSearch(new \DateTime());
				$historyLog->setCreated(new \DateTime());
				$historyLog->setUpdated(new \DateTime());
			}
			$em->persist($historyLog);
			$em->flush();
		}

		return $this->redirect($this->generateUrl('_home', array('word' => $word)));
	}
}
