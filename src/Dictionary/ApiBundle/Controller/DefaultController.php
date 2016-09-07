<?php

namespace Dictionary\ApiBundle\Controller;

use Dictionary\ApiBundle\Entity\Eng2srb;
use Dictionary\ApiBundle\Entity\Eng2srbRepository;
use Dictionary\ApiBundle\Entity\HistoryRepository;
use Dictionary\ApiBundle\Entity\Mismatch;
use Dictionary\ApiBundle\Entity\Word;
use Dictionary\ApiBundle\Model\TranslateManager;
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
class DefaultController extends FOSRestController
{
	/**
	 *
	 * @Get("/translation/{word}", name="api_translation_get", options={"expose"=true})
	 * @View("DictionaryApiBundle:Default:translation.html.twig", templateVar="data")
	 *
	 * @param $word
	 * @return array
	 * @throws \Exception
	 * @internal param word $string
	 */
	public function translationAction($word)
	{
		/** @var  $em EntityManager */
		$em = $this->getDoctrine()->getManager();

		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');

		$translations = $translationManager->translate($word);

//		if(empty($translations)) {
//			$mismatch = new Mismatch();
//			$mismatch->setValue($word);
//			$em->persist($mismatch);
//			$em->flush();
//
//			throw new \Exception('There is no such a word');
//		}

		$serbianTranslations = [];
		foreach ($translations as $translation) {
			$serbianTranslations[] = $translation['srb_id'];
		}
		/** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $em->getRepository('DictionaryApiBundle:Eng2srb');
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
			'translations' => $results
		];
	}
}

