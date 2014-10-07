<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\historyRepository;
use Dictionary\DictionaryBundle\Entity\Synonyms;
use Dictionary\DictionaryBundle\Entity\WordRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Entity\History;

class TranslateManager
{
	/**
	 * @var $em EntityManager
	 */
	private $em;
	/**
	 * @var $wordManager WordManager
	 */
	private $wordManager;
	/**
	 * @var $eng2srbManager Eng2SrbManager
	 */
	private $eng2srbManager;
	/**
	 * @var $historyManager HistoryManager
	 */
	private $historyManager;
	/**
	 * @var $googleTranslator GoogleTranslateProvider
	 */
	private $googleTranslator;

	public function __construct($em, $wordManager, $eng2srbManager, $historyManager, $googleTranslator) {
		$this->em = $em;
		$this->wordManager = $wordManager;
		$this->eng2srbManager = $eng2srbManager;
		$this->historyManager = $historyManager;
		$this->googleTranslator = $googleTranslator;

	}

	public function translate($word) {
		/** @var $wordRepository WordRepository */
		$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
		$english = $wordRepository->findOneBy(array(
			'name' => $word,
			'type' => Word::WORD_ENGLISH
		));

		/** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->createQueryBuilder('eng2srb')
			->select('eng2srb.id as eng2srb_id, eng2srb.updated, serbian.wordType, eng2srb.relevance, english.id as eng_id, english.name, serbian.name as translation')
			->innerJoin('eng2srb.eng', 'english')
			->innerJoin('eng2srb.srb', 'serbian')
			->where('english = :english')
			->andwhere('eng2srb.direction = :direction')
			->andWhere('english.type = :englishType')
			->andWhere('serbian.type = :serbianType')
			->setParameters(array(
				'english' 		=> $english,
				'englishType'	=> Word::WORD_ENGLISH,
				'serbianType'	=> Word::WORD_SERBIAN,
				'direction'		=> Eng2srb::ENG_2_SRB
			))
			->orderBy('serbian.wordType, eng2srb.relevance', 'ASC')
			->getQuery()
			->getResult()
		;

		return $results;
	}

	public function translateFromGoogle($word) {

		$dictionary = $this->googleTranslator->translate($word);
		if (!$dictionary) {
			return false;
		}

		$english = $this->wordManager->findEnglishWord($word);
		foreach ($dictionary as $dict) {
			$type = Word::getWordTypeBy($dict->pos);

			$t = \Transliterator::create('Serbian-Latin/BGN');
			foreach ($dict->terms as $relevance => $term) {
				$serbianTranslation = $t->transliterate($term);
				$serbian = $this->wordManager->findSerbianWord($serbianTranslation, $type);
				$this->eng2srbManager->findTranslation($english, $serbian, Eng2srb::ENG_2_SRB, $relevance);

				$englishTranslations = $dict->entry[$relevance];
				foreach ($englishTranslations->reverse_translation as $revertTraRelevance => $englishTran) {
					$englishReversTrans = $this->wordManager->findEnglishWord($englishTran);
					$this->eng2srbManager->findTranslation($englishReversTrans, $serbian, Eng2srb::SRB_2_ENG, $revertTraRelevance);
				}
			}
		}
		return true;
	}
}