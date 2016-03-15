<?php
/**
 * Created by PhpStorm.
 * User: milos
 * Date: 3/11/16
 * Time: 23:34
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dictionary\DictionaryBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class LoadUserData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$this->__createUser($manager, 'milos3', 'mnov+3@joiz.ch', 'test');
		$this->__createUser($manager, 'milos4', 'mnov+4@joiz.ch', 'test');
	}
	
	
	private function __createUser($manager, $username, $email, $password) {
		/** @var $user User*/
		$user = new User();
		$user->setUsername($username);
		$user->setEmail($email);
		$encoder = new MessageDigestPasswordEncoder('sha512');
		$user->setPassword($encoder->encodePassword($password, $user->getSalt()));
		$user->setEnabled(TRUE);

		$manager->persist($user);
		$manager->flush();
	}
}