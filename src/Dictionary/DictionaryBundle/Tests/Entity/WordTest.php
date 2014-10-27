<?php
/**
 * Joiz IP AG
 * User: milosnovicevic
 * Date: 12/26/13
 * Time: 5:17 PM
 */

namespace Joiz\Chatbundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dictionary\DictionaryBundle\Entity\Word;


/**
 * Class MessageLinkTest
 * @package Joiz\Chatbundle\Tests\Entity
 */
class WordTest extends WebTestCase {

	/**
	 * @covers 
	 */
	public function testGetterAndSetter()
	{
		/** @var $word  Word */
		$word = new Word();

		$this->assertNull($word->getId());

		$this->assertEquals($word, $word->setName('test'));
		$this->assertEquals('test', $word->getName());

		$this->assertEquals($word, $word->setType(Word::WORD_ENGLISH));
		$this->assertEquals(Word::WORD_ENGLISH, $word->getType());

		$date = new \DateTime();
		$this->assertEquals($word, $word->setCreated($date));
		$this->assertEquals($date, $word->getCreated());

		$date = new \DateTime();
		$this->assertEquals($word, $word->setUpdated($date));
		$this->assertEquals($date, $word->getUpdated());


		/** @var $message Message */
//		$message = new Message();
//		$this->assertEquals($word, $word->setMessage($message));
//		$this->assertEquals($message, $word->getMessage());
	}

	/**
	 * @covers Joiz\ChatBundle\Entity\MessageLink::getId
	 */
	public function testGetId() {
		/** @var $word Word */
		$word = $this->getMockBuilder('\Dictionary\DictionaryBundle\Entity\Word')
			->disableOriginalConstructor()
			->getMock();

		$word->expects($this->any())
			->method('getId')
			->will($this->returnValue(1))
		;

		$this->assertEquals(1, $word->getId());
	}
}
