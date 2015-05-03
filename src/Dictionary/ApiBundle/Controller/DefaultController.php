<?php

namespace Dictionary\ApiBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
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
		/** @var  $em EntityManager */
		$em = $this->getDoctrine()->getManager();

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$translations = $translationManager->translate($word);

		if(empty($translations)) {
			throw new \Exception('There is no such a word');
		}

		$serbianTranslations = [];
		foreach ($translations as $translation) {
			$serbianTranslations[] = $translation['srb_id'];
		}
		/** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
		$translationSynonyms = $eng2srbRepository->getSerbianTranslations($serbianTranslations);

		foreach ($translationSynonyms as $synonyms) {
			$serbianWord = $synonyms->getSrb()->getName();
			$latestSearchSynonyms[$serbianWord]['translation'][] = $synonyms->getEng()->getName();
		}

		$results = [];
		foreach ($translations as $translation) {
			$index = Eng2srb::wordType2String($translation['wordType']);
			if(!isset($results[$index])) {
				$results[$index] = [];
			}
			$wordName = $translation['translation'];
			$synonyms = [];
			if(isset($latestSearchSynonyms[$wordName])) {
				$synonyms = $latestSearchSynonyms[$wordName]['translation'];
			}
			$results[$index][] = [
				'translation' => $wordName,
				'synonyms' => $synonyms
			];
		}

		return [
			'word' => $word,
			'translation' => $results
		];
	}

	/**
	 *
	 * @Post("/translation/{direction}")
	 * @View("DictionaryApiBundle:Default:translation.html.twig", templateVar="data")
	 *
	 * @param string $direction
	 * @return array
	 */
	public function getTranslationsAction($direction) {
		return [];
	}

	/**
	 *
	 * @Post("/history/translation")
	 * @View("DictionaryApiBundle:Default:translation.html.twig", templateVar="data")
	 *
	 * @param Request $request
	 * @return array
	 */
	public function historyAction(Request $request) {
		$user = $this->getUser();
		if ($user) {
			/** @var $historyRepository HistoryRepository */
			$historyRepository = $this->getDoctrine()->getRepository('DictionaryBundle:History');
			$histories = $historyRepository->findByLatestSearched($user);
			foreach($histories as $index => $history) {
				$wordIds[] = $history[0]->getWord()->getId();
			}
		} else {
			$historyWord = $request->request->get('history');

			if($historyWord) {
				$historyWord = array_unique($historyWord);
				$words = $this->getDoctrine()->getRepository('DictionaryBundle:Word')->findByName($historyWord);
				/** @var  $eng2srbRepository Eng2srbRepository*/
				$wordIds = [];
				foreach($words as $word) {
					$wordIds[] = $word->getId();
				}
			}
		}

		if(empty($wordIds)) {
			return [];
		}

		$eng2srbRepository = $this->getDoctrine()->getManager()->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->getEnglishTranslations($wordIds);

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
			$historyResult[$englishTranslationName]['translations'][$index][] = $serbianTranslationName;
		}

		$dataToReturn = [];
		if ($user) {
			foreach ($historyResult as $index => $history) {
				$dataToReturn[] = array_merge(['word' => $index], $history);
			}
		} else {
			foreach ($historyWord as $index => $history) {
				$dataToReturn[] = array_merge(['word' => $history], $historyResult[$history]);
			}
		}
		return $dataToReturn;
	}

}
