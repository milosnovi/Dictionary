<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\History;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Word;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param History $history
     * @return array
     *
     * @Route("/history/{id}", name="delete_history_item")
     * @Method({"DELETE"})
     * @Template()
     */
    public function removeHistoryItemAction(Request $request, History $history)
    {
        /** @var $em EntityManager*/
        $em = $this->getDoctrine()->getManager();

        $em->remove($history);
        $em->flush();

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array(
                'success' => true
            ));
        } else {
            return $this->redirect($this->generateUrl('_home'));
        }
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
        if (empty($historyByHits)) {
            return array(
                'historyHits' => []
            );
        }

        foreach($historyByHits as $hit) {
            $englishIds[] = $hit[0]->getWord()->getId();
            $resultHits[$hit[0]->getWord()->getId()] = array(
                'history_id' => $hit[0]->getId(),
                'word_id' => $hit[0]->getWord()->getId(),
                'piles_type' => $hit['pile_type'],
                'hits' => $hit[0]->getHits(),
                'name' => $hit[0]->getWord()->getName()
            );
        }
        /** @var  $eng2srbRepository Eng2srbRepository */
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
