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

	public function __construct($em) {
		$this->em = $em;

	}

	public function translate($word, $user = null) {
		/** @var $wordRepository WordRepository */
		$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
		$english = $wordRepository->findOneBy(array(
			'name' => $word,
			'type' => Word::WORD_ENGLISH
		));

		/** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->createQueryBuilder('eng2srb')
			->select('eng2srb.id as eng2srb_id, serbian.wordType, eng2srb.relevance, english.id as eng_id, english.name, serbian.name as translation')
			->innerJoin('eng2srb.eng', 'english')
			->innerJoin('eng2srb.srb', 'serbian')
			->where('english = :english')
			->andWhere('english.type = :englishType')
			->andWhere('serbian.type = :serbianType')
			->setParameters(array(
				'english' 		=> $english,
				'englishType'	=> Word::WORD_ENGLISH,
				'serbianType'	=> Word::WORD_SERBIAN,
			))
			->orderBy('serbian.wordType, eng2srb.relevance', 'ASC')
			->getQuery()
			->getResult()
		;

		if($results && $user) {
			/** @var $historyRepository HistoryRepository */
			$historyRepository = $this->em->getRepository('DictionaryBundle:History');
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
				$this->em->flush();
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
			$this->em->persist($historyLog);
			$this->em->flush();
		}
		return $results;
	}

	public function translateFromService($word, $user = null) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www.metak.com/recnik/search',
			CURLOPT_USERAGENT => 'Codular Sample cURL Request',
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => array(
				'word' => $word
			)
		));
		$resp = curl_exec($curl);
		$html = '<!DOCTYPE html>
            <html>
 			<meta charset="UTF-8" />
                <body>
                    ' . $resp . '
                </body>
            </html>';
		$crawler = new Crawler($html);

		$serbianTranslationResults = $crawler->filter('#eng2srp li')->each(function (Crawler $node, $i) {
			$sentence = $node->text();
			$explodeTranslate = explode('-', $sentence);
			return trim($explodeTranslate[1]);
		});

		$englishSynonyms = $crawler->filter('#eng2srp p')->each(function (Crawler $node, $i) {
			$sentence = $node->text();
			$synonyms = trim($sentence, "Sinonimi");
			$synonyms = explode(',', $synonyms);
			foreach($synonyms as &$synonym) {
				$synonym = trim($synonym);
			}
			return $synonyms;
		});

		$englishTranslationResults = $crawler->filter('#srp2eng li')->each(function (Crawler $node, $i) {
			$sentence = $node->text();
			$explodeTranslate = explode('-', $sentence);
			return trim($explodeTranslate[1]);
		});

		if (empty($serbianTranslationResults) && empty($englishTranslationResults)) {
			return false;
		}

		if(!empty($serbianTranslationResults)) {
			/** @var $wordRepository WordRepository */
			$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
			$english = $wordRepository->findOneBy(array(
				'name' => $word,
				'type' => Word::WORD_ENGLISH
			));
			if(!$english) {
				/** @var  $english Word */
				$english = new Word();
				$english->setName($word);
				$english->settype(Word::WORD_ENGLISH);
				$english->setCreated(new \DateTime());
				$english->setUpdated(new \DateTime());
				$this->em->persist($english);
				$this->em->flush();
			}

			$this->translateEnglish2Serbian($english, $serbianTranslationResults);

			if ($user) {
				/** @var $historyRepository HistoryRepository */
				$historyRepository = $this->em->getRepository('DictionaryBundle:History');
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
					$this->em->flush();
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
				$this->em->persist($historyLog);
				$this->em->flush();
			}

		}

		if(!empty($englishTranslationResults)) {
			/** @var $wordRepository WordRepository */
			$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
			$serbian = $wordRepository->findOneBy(array(
				'name' => $word,
				'type' => Word::WORD_SERBIAN
			));
			if(!$serbian) {
				/** @var  $english Word */
				$serbian = new Word();
				$serbian->setName($word);
				$serbian->settype(Word::WORD_SERBIAN);
				$serbian->setCreated(new \DateTime());
				$serbian->setUpdated(new \DateTime());
				$this->em->persist($serbian);
				$this->em->flush();
			}
			$this->translateSerbian2English($serbian, $englishTranslationResults);
		}

		if($englishSynonyms) {
			$this->updateSynonyms($englishSynonyms[0], $english);
		}

		return true;
	}

	public function updateSynonyms($englishSynonyms, $english) {
		foreach($englishSynonyms as $word) {
			/** @var  $synonym Word */
			$synonym = new Word();
			$synonym->setName($word);
			$synonym->settype(Word::WORD_ENGLISH);
			$synonym->setCreated(new \DateTime());
			$synonym->setUpdated(new \DateTime());
			$this->em->persist($synonym);

			/** @var  $synonym Synonyms*/
			$synonymEntity = new Synonyms();
			$synonymEntity->setWord($english);
			$synonymEntity->setSynonym($synonym);
			$synonymEntity->setCreated(new \DateTime());
			$synonymEntity->setUpdated(new \DateTime());
			$this->em->persist($synonymEntity);

			$this->em->flush();
		}
	}

	public function translateEnglish2Serbian($english, $serbianTranslationResults) {
		/** @var $wordRepository WordRepository */
		$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
		$serbians = $wordRepository->findBy(array(
			'name' => $serbianTranslationResults,
			'type' => Word::WORD_SERBIAN
		));
		$matchedWords = array();
		/**
		 * @var  $index Integer
		 * @var  $serbian Word
		 */
		foreach($serbians as $index => $serbian) {
			$matchedWords[$serbian->getName()] = $serbian;
		}

		foreach($serbianTranslationResults as $serbianWord) {
			if (isset($matchedWords[$serbianWord])) {
				/** @var $eng2srbRepository Eng2srbRepository */
				$eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
				$results = $eng2srbRepository->createQueryBuilder('eng2srb')
					->select('eng2srb')
					->innerJoin('eng2srb.eng', 'english')
					->innerJoin('eng2srb.srb', 'serbian')
					->where('english = :english')
					->andWhere('serbian = :serbian')
					->andWhere('english.type = :englishType')
					->andWhere('serbian.type = :serbianType')
					->setParameters(array(
						'english' 		=> $english,
						'serbian' 		=> $matchedWords[$serbianWord],
						'englishType'	=> Word::WORD_ENGLISH,
						'serbianType'	=> Word::WORD_SERBIAN,
					))
					->getQuery()
					->getResult();

				if (empty($results)) {
					/** @var  $eng2SrbItem Eng2srb */
					$eng2SrbItem = new Eng2srb();
					$eng2SrbItem->setEng($english);
					$eng2SrbItem->setSrb($matchedWords[$serbianWord]);
					$eng2SrbItem->setCreated(new \DateTime());
					$eng2SrbItem->setUpdated(new \DateTime());
					$this->em->persist($eng2SrbItem);
					$this->em->flush();
				}
			} else {
				/** @var $serbianEntity Word */
				$serbianEntity = new Word();
				$serbianEntity->setName($serbianWord);
				$serbianEntity->settype(Word::WORD_SERBIAN);
				$serbianEntity->setCreated(new \DateTime());
				$serbianEntity->setUpdated(new \DateTime());
				$this->em->persist($serbianEntity);
				$this->em->flush();

				/** @var  $eng2SrbItem Eng2srb */
				$eng2SrbItem = new Eng2srb();
				$eng2SrbItem->setEng($english);
				$eng2SrbItem->setSrb($serbianEntity);
				$eng2SrbItem->setCreated(new \DateTime());
				$eng2SrbItem->setUpdated(new \DateTime());
				$this->em->persist($eng2SrbItem);
				$this->em->flush();
			}
		}
	}

	public function translateSerbian2English($serbian, $englishTranslationResults) {
		/** @var $wordRepository WordRepository */
		$wordRepository = $this->em->getRepository('DictionaryBundle:Word');
		$englishWords = $wordRepository->findBy(array(
			'name' => $englishTranslationResults,
			'type' => Word::WORD_ENGLISH
		));
		$matchedWords = array();
		/**
		 * @var  $index Integer
		 * @var  $serbian Word
		 */
		foreach($englishWords as $index => $english) {
			$matchedWords[$english->getName()] = $english;
		}

		foreach($englishTranslationResults as $englishWords) {
			if (isset($matchedWords[$englishWords])) {
				/** @var $eng2srbRepository Eng2srbRepository */
				$eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
				$results = $eng2srbRepository->createQueryBuilder('eng2srb')
					->select('eng2srb')
					->innerJoin('eng2srb.eng', 'english')
					->innerJoin('eng2srb.srb', 'serbian')
					->where('english = :english')
					->andWhere('serbian = :serbian')
					->andWhere('english.type = :englishType')
					->andWhere('serbian.type = :serbianType')
					->setParameters(array(
						'english' 		=> $matchedWords[$englishWords],
						'serbian' 		=> $serbian,
						'englishType'	=> Word::WORD_ENGLISH,
						'serbianType'	=> Word::WORD_SERBIAN,
					))
					->getQuery()
					->getResult();

				if (empty($results)) {
					/** @var  $eng2SrbItem Eng2srb */
					$eng2SrbItem = new Eng2srb();
					$eng2SrbItem->setEng($matchedWords[$englishWords]);
					$eng2SrbItem->setSrb($serbian);
					$eng2SrbItem->setCreated(new \DateTime());
					$eng2SrbItem->setUpdated(new \DateTime());
					$this->em->persist($eng2SrbItem);
					$this->em->flush();
				}
			} else {
				/** @var $englishEntity Word */
				$englishEntity = new Word();
				$englishEntity->setName($englishWords);
				$englishEntity->settype(Word::WORD_ENGLISH);
				$englishEntity->setCreated(new \DateTime());
				$englishEntity->setUpdated(new \DateTime());
				$this->em->persist($englishEntity);
				$this->em->flush();

				/** @var  $eng2SrbItem Eng2srb */
				$eng2SrbItem = new Eng2srb();
				$eng2SrbItem->setEng($englishEntity);
				$eng2SrbItem->setSrb($serbian);
				$eng2SrbItem->setCreated(new \DateTime());
				$eng2SrbItem->setUpdated(new \DateTime());
				$this->em->persist($eng2SrbItem);
				$this->em->flush();
			}
		}
	}

	public function findTranslation($english, $serbian, $direction, $relevance) {
		/** @var $eng2srbRepository Eng2srbRepository */
		$eng2srbRepository = $this->em->getRepository('DictionaryBundle:Eng2srb');
		$eng2SrbItem = $eng2srbRepository->getTranslation($english, $serbian, $direction);

		if (empty($eng2SrbItem)) {
			/** @var  $eng2SrbItem Eng2srb */
			$eng2SrbItem = new Eng2srb();
			$eng2SrbItem->setEng($english);
			$eng2SrbItem->setSrb($serbian);
			$eng2SrbItem->setRelevance($relevance + 1);
			$eng2SrbItem->setDirection($direction);
			$this->em->persist($eng2SrbItem);
			$this->em->flush();
		} else {
			$eng2SrbItem->setRelevance($relevance + 1);
			$eng2SrbItem->setDirection($direction);
			$this->em->persist($eng2SrbItem);
			$this->em->flush();
		}

		return $eng2SrbItem;
	}

}