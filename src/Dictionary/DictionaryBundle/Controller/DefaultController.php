<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\User;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
			$translations = $translationManager->translate($word);
			$success = 1 < count($translations);
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

		$histories = $historyRepository->getLatestSearched($user);
//		\Doctrine\Common\Util\Debug::dump($histories,3);
//		exit;
		$englishIds = array();
		foreach($histories as $index => $history) {
			$englishIds[] = $history[0]->getWord()->getId();
			$historyResult[$history[0]->getWord()->getName()] = array(
				'history_id' => $history[0]->getId(),
				'word_id' => $history[0]->getWord()->getId(),
				'piles_type' => $history['pile_type']
			);
			if ($index == 0) {
				$word = $history[0]->getWord()->getName();
			}
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

			$index = Eng2srb::wordType2String($result->getWordType());
			if ($englishTranslationName == $word) {
				$latestSearch[] = $serbianTranslationName;
			}

			if(!isset($historyResult[$englishTranslationName]['translations'][$index])) {
				$historyResult[$englishTranslationName]['translations'][$index] = array();
			}
			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
		}

		$latestSearchSynonyms = array();
		if(!empty($latestSearch)) {
			/** @var $eng2srbRepository Eng2srbRepository */
			$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
			$translationSynonyms = $eng2srbRepository->createQueryBuilder('eng2srb')
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
			foreach ($translationSynonyms as $synonyms) {
				$serbianWord = $synonyms->getSrb()->getName();
				$latestSearchSynonyms[$serbianWord]['translation'][] = $synonyms->getEng()->getName();
			}
		}
		$latestSearch = isset($historyResult[$word]) ? $historyResult[$word] : false;
//		var_dump($historyResult);
        return array(
			'latestSearch'			=> $latestSearch,
			'latestSearchSynonyms'	=> $latestSearchSynonyms,
			'latestWord'			=> $word,
			'histories' 			=> $historyResult,
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

		/** @var $user User */
		$user = $this->getUser();

		$success = $translationManager->translate($word, $user);
		if(!$success) {
			$response = $translationManager->translateFromGoogle($word, $user);
			$success = $response['success'];
		}

		if (!$success) {
			if(isset($response['similar'])) {
				$this->get('session')->getFlashBag()->add('notice', "See translation of <a href=" . $this->generateUrl('_home', array('word' => $response['similar'])). ">" .$response['similar']. "</a>");
			} else {
				$this->get('session')->getFlashBag()->add('notice', 'No results');
			}
		} else {
			if ($user) {
				$this->get('dictionary.historyManager')->updateHistoryLog($user, $word);
			}
		}

		return $this->redirect($this->generateUrl('_home'));
	}


}
