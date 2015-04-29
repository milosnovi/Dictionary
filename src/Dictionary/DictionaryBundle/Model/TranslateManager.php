<?php

namespace Dictionary\DictionaryBundle\Model;


use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\WordRepository;
use Doctrine\ORM\EntityManager;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Word;

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
			->select('eng2srb.id as eng2srb_id, eng2srb.updated, eng2srb.wordType, eng2srb.relevance, english.id as eng_id, serbian.id as srb_id, english.name, serbian.name as translation')
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
			->orderBy('eng2srb.wordType, eng2srb.relevance', 'ASC')
			->getQuery()
			->getResult()
		;
		return $results;
	}

	public function translateFromGoogle($word, $forceUpdate = false) {
		$dictionary = $this->googleTranslator->translate($word);

		$origin = null;
		if (isset($dictionary->sentences[0])) {
			$origin = $dictionary->sentences[0]->orig;
		}
		\Doctrine\Common\Util\Debug::dump($dictionary,2);
		exit;
		if (!isset($dictionary->dict)) {
			return array(
				'success' => false
			);
		}

		$english = $this->wordManager->findEnglishWord($word);

		foreach ($dictionary->dict as $dict) {
			if ($dict->base_form != $origin) {
				return array(
					'success' => false,
					'similar' => $dict->base_form
				);
			}

			$type = Eng2srb::getWordTypeBy($dict->pos);
			if ($type) {
				$t = \Transliterator::create('Serbian-Latin/BGN');
				foreach ($dict->terms as $relevance => $term) {
					$serbianTranslation = $t->transliterate($term);
					$serbian = $this->wordManager->findSerbianWord($serbianTranslation);
					if($forceUpdate) {
						$this->eng2srbManager->removeTranslation($english, $serbian, Eng2srb::ENG_2_SRB);
					}
					$this->eng2srbManager->findAndCreateTranslation($english, $serbian, Eng2srb::ENG_2_SRB, $relevance, $type);

					$englishTranslations = $dict->entry[$relevance];
					foreach ($englishTranslations->reverse_translation as $revertTraRelevance => $englishTran) {
						$englishReversTrans = $this->wordManager->findEnglishWord($englishTran);
						if($forceUpdate) {
							$this->eng2srbManager->removeTranslation($englishReversTrans, $serbian, Eng2srb::SRB_2_ENG);
						}
						$this->eng2srbManager->findAndCreateTranslation($englishReversTrans, $serbian, Eng2srb::SRB_2_ENG, $revertTraRelevance, $type);
					}
				}
			}
		}
		return array(
			'success' => true
		);
	}
}