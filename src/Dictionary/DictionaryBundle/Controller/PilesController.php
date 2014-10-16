<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\Eng2srb;
use Dictionary\DictionaryBundle\Entity\Eng2srbRepository;
use Dictionary\DictionaryBundle\Entity\Piles;
use Dictionary\DictionaryBundle\Entity\PilesRepository;
use Dictionary\DictionaryBundle\Entity\User;
use Dictionary\DictionaryBundle\Entity\Word;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class PilesController
 * @package Dictionary\DictionaryBundle\Controller
 */
class PilesController extends Controller
{

    /**
     * @param Request $request
     * @return array
     *
     * @Route("piles", name="dictionary_piles")
     * @Template()
     */
    public function indexAction(Request $request)
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

        $resultToReturn = array();
        foreach($piles as $pile) {
            $pileType = $pile->getType();
            if(!isset($resultToReturn[$pileType])) {
                $resultToReturn[$pileType] = array();
            }
            $resultToReturn[$pileType][] = array(
                'pile' => $pile,
                'translation' => $historyResult[$pile->getWord()->getId()]
            );
        }
        return array(
            'resultToReturn' => $resultToReturn
        );
    }

	/**
	 * @param Request $request
	 * @return array
	 *
	 * @Route("word/{word}/pile/{pileId}", name="move_2_piles")
	 * @Template()
	 */
    public function move2pilesAction(Request $request, Word $word, $pileId)
    {
        /** @var $user User*/
        $user = $this->getUser();
        if(!$user) {
            throw new AccessDeniedException();
        }

        /** @var  $pilesRepository PilesRepository */
        $pilesRepository = $this->getDoctrine()->getRepository('DictionaryBundle:Piles');
        $pile = $pilesRepository->findUserPile($word, $user);

        if(empty($pile)) {
            $pile = new Piles();
            $pile->setUser($user);
            $pile->setWord($word);
        }
        $pile->setType($pileId);

        $em = $this->getDoctrine()->getManager();
        $em->persist($pile);
        $em->flush();

        return $this->redirect($this->generateUrl('dictionary_piles'));
    }

}
