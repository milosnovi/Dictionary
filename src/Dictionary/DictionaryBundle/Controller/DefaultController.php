<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Serbian;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'milos');
    }

	/**
	 * @Route("/{word}", name="_demo")
	 * @Template()
	 */
	public function matchAction($word)
	{
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
                <body>
                    ' . $resp . '
                </body>
            </html>';
		$crawler = new Crawler($html);

		$eng2Srb = $crawler->filter('#eng2srp li')->each(function (Crawler $node, $i) {
			$sentence = $node->text();
			$explodeTranslate = explode('-', $sentence);
			return trim($explodeTranslate[1]);
		});

		$em = $this->getDoctrine()->getManager();
		/** @var $englishRepository EnglishRepository */
		$englishRepository = $em->getRepository('DictionaryBundle:English');
		if(!($english = $englishRepository->findOneByWord($word))) {
			$english = new English();
			$english->setWord($word);
			$em->persist($english);
			$em->flush();
		}

		/** @var $englishRepository EnglishRepository */
		$serbianRepository = $em->getRepository('DictionaryBundle:Serbian');
		$serbians = $serbianRepository->findAll(array('word' => $eng2Srb));
		$matchedWords = array();
		foreach($serbians as $index => $serbian) {
			$matchedWords[$serbian->getWord()] = $serbian;
		}
		foreach($eng2Srb as $serbianWord) {
			if (!isset($matchedWords[$serbianWord])) {
				/** @var $serbian Serbian */
				$serbian = new Serbian();
				$serbian->setName($serbianWord);
				$em->persist($serbian);
				$em->flush();
			} else {
				$serbian = $matchedWords[$serbianWord];
			}

			
			$eng2SrbItem = new eng2srb();
			$eng2SrbItem->setEnId($english);
			$eng2SrbItem->setSrbId($serbian);
			$em->persist($eng2SrbItem);
//            \Doctrine\Common\Util\Debug::dump($eng2SrbItem);
//            exit;
		}

		$em->flush();
		var_dump($eng2Srb);exit;
		return array();
	}
}
