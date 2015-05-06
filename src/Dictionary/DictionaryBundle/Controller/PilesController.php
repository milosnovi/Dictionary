<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\Piles;
use Dictionary\DictionaryBundle\Entity\PilesRepository;
use Dictionary\DictionaryBundle\Entity\User;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Entity\WordRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class PilesController
 * @package Dictionary\DictionaryBundle\Controller
 */
class PilesController extends Controller
{

    /**
     * @return array
     *
     * @Route("piles", name="dictionary_piles")
     * @Template()
     */
    public function indexAction()
    {
        /** @var  $user User */
        $user = $this->getUser();
        /** @var  $pilesRepository PilesRepository */
        $pilesRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Piles');
        $piles = $pilesRepository->findPiles($user);


        $englishIds = array();
        /** @var $pile Piles */
        foreach($piles as $pile) {
            $englishIds[] = $pile->getWord()->getId();
        }
        /** @var  $eng2srbRepository Eng2srbRepository */
        $eng2srbRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Eng2srb');
        $results = $eng2srbRepository->getEnglishTranslations($englishIds);

        $resultToReturn = [
            Piles::TYPE_KNOW        => [],
            Piles::TYPE_NOT_SURE    => [],
            Piles::TYPE_DO_NOT_KNOW => []
        ];

        if(empty($results)) {
            return [
                'resultToReturn' => $resultToReturn
            ];
        }

        /** @var $result Eng2srb*/
        foreach($results as $result) {
            /** @var  $serbianTransations Word */
            /** @var  $englishTransations Word */
            $serbianTransations = $result->getSrb();
            $englishTransations = $result->getEng();

            $serbianTranslationName = $serbianTransations->getName();

            $index = Eng2srb::wordType2String($result->getWordType());

            if(!isset($historyResult[$englishTransations->getId()]['translations'][$index])) {
                $historyResult[$englishTransations->getId()]['id'] = $englishTransations->getId();
                $historyResult[$englishTransations->getId()]['name'] = $englishTransations->getName();
                $historyResult[$englishTransations->getId()]['translations'][$index] = array();
            }
            $historyResult[$englishTransations->getId()]['translations'][$index][] = $serbianTranslationName;
        }

        foreach($piles as $pile) {
            $resultToReturn[$pile->getType()][] = array(
                'pile' => $pile,
                'translation' => $historyResult[$pile->getWord()->getId()]
            );
        }

        return [
            'resultToReturn' => $resultToReturn
        ];
    }

	/**
	 * @param Request $request
	 * @param string $word
	 * @param string $pileId
	 * @return array
	 *
	 * @Route("word/{word}/pile/{pileId}", name="move_2_piles")
	 * @Template()
	 */
    public function move2pilesAction(Request $request, $word, $pileId)
    {
        /** @var  $wordRepository WordRepository */
        $wordRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Word');
        $wordEntity = $wordRepository->findOneBy(['name' => $word, 'type' => Word::WORD_ENGLISH]);

        /** @var $user User*/
        $user = $this->getUser();
        if(!$user) {
            throw new AccessDeniedException();
        }

        /** @var  $pilesRepository PilesRepository */
        $pilesRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Piles');
        $pile = $pilesRepository->findUserPile($wordEntity, $user);

        if(empty($pile)) {
            $pile = new Piles();
            $pile->setUser($user);
            $pile->setWord($wordEntity);
        }
        $pile->setType($pileId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($pile);
        $em->flush();

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array(
               'success' => true
            ));
        } else {
            return $this->redirect($this->generateUrl('dictionary_piles'));
        }
    }

    /**
     * @param Request $request
     * @param Piles $pile
     * @return array
     *
     * @Route("/pile/{id}", name="delete_pile_item")
     * @Method({"DELETE"})
     * @Template()
     */
    public function removeHistoryItemAction(Request $request, Piles $pile)
    {
        /** @var $em EntityManager*/
        $em = $this->getDoctrine()->getManager();

        $em->remove($pile);
        $em->flush();

        if ($request->isXMLHttpRequest()) {
            return new JsonResponse(array(
                'success' => true
            ));
        } else {
            return $this->redirect($this->generateUrl('dictionary_piles'));
        }
    }

}
