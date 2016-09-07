<?php

namespace Dictionary\ApiBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Mismatch;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Model\HistoryManager;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Prefix("/v1")
 */
class HistoryController extends FOSRestController
{
	/**
	 *
	 * @Get("/history/{word}/update", name="api_update_history", options={"expose"=true})
	 * @View("DictionaryApiBundle:Default:update_history.html.twig", templateVar="data")
	 *
	 * @param $word
	 * @return array
	 * @throws \Exception
	 * @internal param word $string
	 */
	public function updateHistoryAction(Request $request, $word) {
		$cookies = $request->cookies;

		if(!$cookies->has('dictionary_permanent_cookie')) {
			return ['success' => false];
		}
		$anoymousCookie = $cookies->get('dictionary_permanent_cookie');

		/** @var  $historyManager HistoryManager */
		$historyManager = $this->get('dictionary.historyManager');
		$historyManager->updateHistoryLog($anoymousCookie, $word);

		return ['success' => true];
	}

	/**
	 *
	 * @Get("/user/history", name="_api_history", options={"expose"=true})
	 *
	 * @param Request $request
	 * @return array
	 * @throws \Exception
	 */
	public function userHistoryAction(Request $request) {
		$cookies = $request->cookies;

		if(!$cookies->has('dictionary_permanent_cookie')) {
			return ['success' => false];
		}
		$anoymousCookie = $cookies->get('dictionary_permanent_cookie');

//		$user = $this->getUser();
//		if(!$user) {
//			throw new \Exception('User is not logged in');
//		}

		/** @var $historyRepository HistoryRepository */
		$historyRepository = $this->getDoctrine()->getRepository('DictionaryBundle:History');
		$histories = $historyRepository->findByLatestSearched($anoymousCookie);
		foreach($histories as $index => $history) {
			$wordIds[] = $history[0]->getWord()->getId();
		}

		if(empty($wordIds)) {
			return [];
		}

        /** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $this->getDoctrine()->getManager()->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->getEnglishTranslations($wordIds);
//\Doctrine\Common\Util\Debug::dump($results, 2);exit;
		/** @var $result Eng2srb*/
		foreach($results as $result) {
			/** @var  $serbianTransations Word */
			/** @var  $englishTransations Word */
			$serbianTransations = $result->getSrb();
			$englishTransations = $result->getEng();

			$serbianTranslationName = $serbianTransations->getName();
			$englishTranslationName = $englishTransations->getName();

			$index = Eng2srb::wordType2String($result->getWordType());

			if(!isset($historyResult[$englishTranslationName]['translations'][$index])) {
				$historyResult[$englishTranslationName]['translations'][$index] = array();
			}
            $historyResult[$englishTranslationName]['id'] = $englishTransations->getId();
			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
		}

		$dataToReturn = [];
		foreach ($historyResult as $index => $history) {
			$dataToReturn[] = array_merge(['word' => $index], $history);
		}
		return $dataToReturn;
	}

}
