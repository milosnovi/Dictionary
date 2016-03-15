<?php
/**
 * Created by PhpStorm.
 * User: milos
 * Date: 3/11/16
 * Time: 23:34
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Entity\Eng2srb;

class LoadWordData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$words = [
			'welcome' => [
				Eng2srb::WORD_TYPE_NOUN => ['doček', 'dobrodošlica'],
				Eng2srb::WORD_TYPE_ADJ => ['dobrodošao'],
				Eng2srb::WORD_TYPE_VERB => ['dočekati']
			],
			'devotion' => [
				Eng2srb::WORD_TYPE_NOUN => ['odanost', 'privrzenost', 'zalaganje']
			],
			'book' => [
				Eng2srb::WORD_TYPE_NOUN => ['knjiga', 'libreto'],
				Eng2srb::WORD_TYPE_VERB => ['rezervisati', 'angažovati']
			]
		];

		foreach($words as $wordValue => $wordTranslations) {
			$word = new Word();
			$word->setName($wordValue);
			$word->setType(Word::WORD_ENGLISH);
			$manager->persist($word);

			foreach($wordTranslations as $type => $translations) {
				foreach($translations as $index => $translation) {
					$wordTranslation = new Word();
					$wordTranslation->setName($translation);
					$wordTranslation->setType(Word::WORD_SERBIAN);
					$manager->persist($wordTranslation);

					$eng2srb = new Eng2srb();
					$eng2srb->setEng($word);
					$eng2srb->setSrb($wordTranslation);
					$eng2srb->setRelevance($index);
					$eng2srb->setDirection(Eng2srb::ENG_2_SRB);
					$eng2srb->setWordType($type);
					$manager->persist($eng2srb);
				}
				$manager->flush();
			}
		}

	}
}