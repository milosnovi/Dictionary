<?php

namespace Dictionary\ApiBundle\Controller;

use Dictionary\DictionaryBundle\Model\TranslateManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Prefix("/v1")
 */
class DefaultController extends FOSRestController
{
	/**
	 *
	 * @Get("/translation/{word}")
	 * @View("DictionaryApiBundle:Default:translation.html.twig", templateVar="data")
	 *
	 * @param string word
	 * @return array
	 */
	public function translationAction($word)
	{
		/** @var  $em EntityManager*/
		$em = $this->getDoctrine()->getManager();

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$translations = $translationManager->translate($word);
		return $translations;

////		$success = 1 < count($translations);
////		if(!$success) {
////			$response = $translationManager->translateFromGoogle($word);
////			$success = $response['success'];
////		}
//\Doctrine\Common\Util\Debug::dump($translations,2);
////		exit;
////		$historyResult = array();
////
////		/** @var $historyRepository HistoryRepository */
////		$historyRepository = $em->getRepository('DictionaryBundle:History');
////		$histories = $historyRepository->getLatestSearched($user);
////		$englishIds = array();
////		foreach($histories as $index => $history) {
////			$englishIds[] = $history[0]->getWord()->getId();
////			$historyResult[$history[0]->getWord()->getName()] = array(
////				'history_id' => $history[0]->getId(),
////				'word_id' => $history[0]->getWord()->getId(),
////				'piles_type' => $history['pile_type']
////			);
////			if ($index == 0) {
////				$latestSerachWordName = $history[0]->getWord()->getName();
////			}
////		}
////
////		/** @var  $eng2srbRepository Eng2srbRepository*/
////		$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
////		$results = $eng2srbRepository->getEnglishTranslations($englishIds);
////		/** @var $result Eng2srb*/
////		foreach($results as $result) {
////			/** @var  $serbianTransations Word */
////			/** @var  $englishTransations Word */
////			$serbianTransations = $result->getSrb();
////			$englishTransations = $result->getEng();
////
////			$serbianTranslationName = $serbianTransations->getName();
////			$englishTranslationName = $englishTransations->getName();
////
////			$index = Eng2srb::wordType2String($result->getWordType());
////			if ($englishTranslationName == $latestSerachWordName) {
////				$latestSearch[] = $serbianTransations->getId();
////			}
////
////			if(!isset($historyResult[$englishTranslationName]['translations'][$index])) {
////				$historyResult[$englishTranslationName]['translations'][$index] = array();
////			}
////			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
////		}
////		$latestSearchSynonyms = array();
////		if(!$success) {
////			$latestSearch = false;
////		}
//
//		/** @var $eng2srbRepository Eng2srbRepository */
//		$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
//		$translationSynonyms = $eng2srbRepository->getSerbianTranslations($latestSearch);
//		$latestSearchSynonyms = array();
//		/** @var $synonyms Eng2srb */
//		foreach ($translationSynonyms as $synonyms) {
//			$serbianWord = $synonyms->getSrb()->getName();
//			$latestSearchSynonyms[$serbianWord]['translation'][] = $synonyms->getEng()->getName();
//		}
//		$latestSearch = isset($historyResult[$latestSerachWordName]) ? $historyResult[$latestSerachWordName] : false;
//		\Doctrine\Common\Util\Debug::dump($translations,2);
//		exit;
//		return [
//			'latestSearch'			=> $latestSearch,
//			'latestSearchSynonyms'	=> $latestSearchSynonyms,
//			'latestWord'			=> $word,
//			'histories' 			=> $historyResult,
//			'errorMessage'			=> $errorMessage
//		];

//		$view = View::create()
//			->setStatusCode(200)
//			->setData($user)
//			->setTemplate('DictionaryApiBundle:Default:translation.html.twig')
//		;
//
//		return $this->get('fos_rest.view_handler')->handle($view);
	}
}
