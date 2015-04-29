<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Mismatch;
use Dictionary\DictionaryBundle\Entity\User;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
		$errorMessage = false;
		$success = false;
		if ($word) {
			$translations = $translationManager->translate($word);
			$success = 1 < count($translations);
//			if(!$success) {
//				$response = $translationManager->translateFromGoogle($word, $user);
//				$success = $response['success'];
//			}

			if ($success) {
				$this->get('dictionary.historyManager')->updateHistoryLog($user, $word);
			} else {
				if(isset($response['similar'])) {
					$errorMessage = "See translation of <a href=" . $this->generateUrl('_home', array('word' => $response['similar'])). ">" .$response['similar']. "</a>";
				} else {
					$errorMessage = 'There is no result!';
					$mismatch = new Mismatch();
					$mismatch->setValue($word);
					$em->persist($mismatch);
					$em->flush();

				}
			}
		}


		$historyResult = array();

		/** @var $historyRepository HistoryRepository */
		$historyRepository = $em->getRepository('DictionaryBundle:History');
		$histories = $historyRepository->findByLatestSearched($user);
		$englishIds = array();
		foreach($histories as $index => $history) {
			$englishIds[] = $history[0]->getWord()->getId();
			$historyResult[$history[0]->getWord()->getName()] = array(
				'history_id' => $history[0]->getId(),
				'word_id' => $history[0]->getWord()->getId(),
				'piles_type' => $history['pile_type']
			);
			if ($index == 0) {
				$latestSerachWordName = $history[0]->getWord()->getName();
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
			if ($englishTranslationName == $latestSerachWordName) {
				$latestSearch[] = $serbianTransations->getId();
			}

			if(!isset($historyResult[$englishTranslationName]['translations'][$index])) {
				$historyResult[$englishTranslationName]['translations'][$index] = array();
			}
			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
		}
		$latestSearchSynonyms = array();
		if(!$success) {
			$latestSearch = false;
		}

		if(!empty($latestSearch)) {
			/** @var $eng2srbRepository Eng2srbRepository */
			$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
			$translationSynonyms = $eng2srbRepository->getSerbianTranslations($latestSearch);
			$latestSearchSynonyms = array();
			/** @var $synonyms Eng2srb */
			foreach ($translationSynonyms as $synonyms) {
				$serbianWord = $synonyms->getSrb()->getName();
				$latestSearchSynonyms[$serbianWord]['translation'][] = $synonyms->getEng()->getName();
			}
			$latestSearch = isset($historyResult[$latestSerachWordName]) ? $historyResult[$latestSerachWordName] : false;
		}
        return [
			'latestSearch'			=> $latestSearch,
			'latestSearchSynonyms'	=> $latestSearchSynonyms,
			'latestWord'			=> $word,
			'histories' 			=> $historyResult,
			'errorMessage'			=> $errorMessage
		];
    }

	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("/update/{word}/{type}/google", name="_update_word_from_google")
	 * @Template()
	 */
	public function updateWordAction(Request $request, $word, $type) {
		/** @var  $em EntityManager*/
		$em = $this->getDoctrine()->getManager();

		if ($this->get('security.context')->isGranted('ROLE_BRAND')) {
			throw new AccessDeniedHttpException();
		}

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$translations = $translationManager->translateFromGoogle($word, true);
		return new JsonResponse([
			'success' => $translations['success']
		]);
	}

	/**
	 * @param Request $request
	 *
	 * @Route("/home", name="_home_api")
	 * @Template()
	 */
	public function indexApiAction()
	{
		return [];
	}

}
