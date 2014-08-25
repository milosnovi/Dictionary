<?php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Entity\eng2srb;
use Acme\DemoBundle\Entity\English;
use Acme\DemoBundle\Entity\Serbian;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;
use Acme\DemoBundle\Entity\EnglishRepository;


class DemoController extends Controller
{
    /**
     * @Route("/{word}", name="_demo")
     * @Template()
     */
    public function indexAction($word)
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
        $englishRepository = $em->getRepository('AcmeDemoBundle:English');
        if(!($english = $englishRepository->findOneByWord($word))) {
            $english = new English();
            $english->setWord($word);
            $em->persist($english);
            $em->flush();
        }

        /** @var $englishRepository EnglishRepository */
        $serbianRepository = $em->getRepository('AcmeDemoBundle:Serbian');
        $serbians = $serbianRepository->findAll(array('word' => $eng2Srb));
        $matchedWords = array();
        foreach($serbians as $index => $serbian) {
            $matchedWords[$serbian->getWord()] = $serbian;
        }
        foreach($eng2Srb as $serbianWord) {
            if (!isset($matchedWords[$serbianWord])) {
                $serbian = new Serbian();
                $serbian->setWord($serbianWord);
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

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mailer = $this->get('mailer');

            // .. setup a message and send it
            // http://symfony.com/doc/current/cookbook/email.html

            $request->getSession()->getFlashBag()->set('notice', 'Message sent!');

            return new RedirectResponse($this->generateUrl('_demo'));
        }

        return array('form' => $form->createView());
    }
}
