<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\History;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\User;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("/", name="_home")
	 * @Template()
	 */
    public function indexAction(Request $request)
    {
		/** @var  $em EntityManager*/
		$em = $this->getDoctrine()->getManager();

		/** @var $user User */
		$user = $this->getUser();

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$word = strtolower($request->get('word'));
		if ($word) {
			$success = $translationManager->translate($word);
			if(!$success) {
				$success = $translationManager->translateFromGoogle($word);
			}
			if ($success) {
				$this->get('dictionary.historyManager')->updateHistoryLog($user, $word);
			}
		}

		/** @var $historyRepository HistoryRepository */
		$historyRepository = $em->getRepository('DictionaryBundle:History');

		$historyResult = array();
		$resultHits = array();

		$histories = $historyRepository->getLatestSearched($user);
		$englishIds = array();
		foreach($histories as $index => $history) {
			$englishIds[] = $history->getWord()->getId();
			$historyResult[$history->getWord()->getName()] = array();
			if ($index == 0) {
				$word = $history->getWord()->getName();
			}
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

		/** @var $result Eng2srb*/
		foreach($results as $result) {
			/** @var  $serbianTransations Word */
			/** @var  $englishTransations Word */
			$serbianTransations = $result->getSrb();
			$englishTransations = $result->getEng();

			$serbianTranslationName = $serbianTransations->getName();
			$englishTranslationName = $englishTransations->getName();

			$index = Word::wordType2String($serbianTransations->getWordType());
			if ($englishTranslationName == $word) {
				$latestSearch[] = $serbianTranslationName;
			}

			if(!isset($historyResult[$englishTranslationName]['translations'][$index])) {
				$historyResult[$englishTranslationName]['translations'][$index] = array();
				$resultHits[$englishTranslationName]['translations'][$index] = array();
			}
			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
			$resultHits[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
		}

		$latestSearchSynonyms = array();
		if(!empty($latestSearch)) {
			/** @var $eng2srbRepository Eng2srbRepository */
			$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
			$translationSinonyms = $eng2srbRepository->createQueryBuilder('eng2srb')
				->select('eng2srb, english, serbian')
				->innerJoin('eng2srb.eng', 'english')
				->innerJoin('eng2srb.srb', 'serbian')
				->where('serbian.name IN (:serbianWords)')
				->andWhere('eng2srb.direction = :direction')
				->andWhere('english.type = :englishType')
				->andWhere('serbian.type = :serbianType')
				->setParameters(array(
					'serbianWords' => $latestSearch,
					'englishType' => Word::WORD_ENGLISH,
					'serbianType' => Word::WORD_SERBIAN,
					'direction' => Eng2srb::SRB_2_ENG
				))
				->orderBy('serbian.name, eng2srb.relevance', 'ASC')
				->getQuery()
				->getResult();

			$latestSearchSynonyms = array();
			/** @var $synonyms Eng2srb*/
			foreach ($translationSinonyms as $synonyms) {
				$serbianWord = $synonyms->getSrb()->getName();
				$latestSearchSynonyms[$serbianWord]['translation'][] = $synonyms->getEng()->getName();
			}
		}
		$latestSearch = isset($historyResult[$word]) ? $historyResult[$word] : false;
        return array(
			'latestSearch'			=> $latestSearch,
			'latestSearchSynonyms'	=> $latestSearchSynonyms,
			'latestWord'			=> $word,
			'histories' 			=> $historyResult,
			'historyHits' 			=> $resultHits
		);
    }

	/**
	 * @param $request Request
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 *
	 * @Route("/translate", name="_translate")
	 */
	public function matchAction(Request $request) {
		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$word = strtolower($request->get('q'));
		if (empty($word)) {
			return $this->redirect($this->generateUrl('_home'));
		}

		$user = $this->getUser();

		$success = $translationManager->translate($word, $user);
		if(!$success) {
			$success = $translationManager->translateFromGoogle($word, $user);
		}

		if (!$success) {
			$this->get('session')->getFlashBag()->add('notice', 'No results');
		} else {
			if ($user) {
				$this->get('dictionary.historyManager')->updateHistoryLog($user, $word);
			}
		}

		return $this->redirect($this->generateUrl('_home'));

	}


}
