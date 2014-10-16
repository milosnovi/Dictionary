<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HistoryController extends Controller
{
	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("/history/clear", name="clear_history")
	 * @Template()
	 */
    public function clearHistoryAction(Request $request)
    {

    }

    /**
     * @param Request $request
     * @return array
     *
     * @Route("/history/most-offen", name="most_offen")
     * @Template()
     */
    public function mostOffenAction(Request $request)
    {
        /** @var  $em EntityManager*/
        $em = $this->getDoctrine()->getManager();

        /** @var $user User */
        $user = $this->getUser();

        /** @var $historyRepository HistoryRepository */
        $historyRepository = $em->getRepository('DictionaryBundle:History');

        $historyByHits = $historyRepository->getSearchedByHits($user);

        foreach($historyByHits as $hit) {
            $englishIds[] = $hit->getWord()->getId();
            $resultHits[$hit->getWord()->getId()] = array(
                'id'   => $hit->getWord()->getId(),
                'hits' => $hit->getHits(),
                'name' => $hit->getWord()->getName()
            );
        }
        /** @var  $eng2srbRepository Eng2srbRepository*/
        $eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
        $results = $eng2srbRepository->getEnglishTranslations($englishIds);
        /** @var $result Eng2srb*/
        foreach($results as $result) {
            /** @var  $serbianTransations Word */
            /** @var  $englishTransations Word */
            $serbianTransations = $result->getSrb();
            $englishTransations = $result->getEng();

            $serbianTranslationName = $serbianTransations->getName();

            $index = Eng2srb::wordType2String($result->getWordType());

            if(!isset($resultHits[$englishTransations->getId()]['translations'][$index])) {
                $resultHits[$englishTransations->getId()]['translations'][$index] = array();
            }
            $resultHits[$englishTransations->getId()]['translations'][$index][] = $serbianTranslationName;
        }

        return array(
            'historyHits' => $resultHits
        );

    }
}
