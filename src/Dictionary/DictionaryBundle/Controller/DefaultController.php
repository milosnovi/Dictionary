<?php

namespace Dictionary\DictionaryBundle\Controller;

use Dictionary\DictionaryBundle\Entity\History;
use Dictionary\DictionaryBundle\Entity\HistoryRepository;
use Dictionary\DictionaryBundle\Entity\Word;
use Dictionary\DictionaryBundle\Model\TranslateManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		$em = $this->getDoctrine()->getManager();

		$user = $this->getUser();

		/** @var $historyRepository HistoryRepository */
		$historyRepository = $em->getRepository('DictionaryBundle:History');

		$resultSet = array();
		$resultHits = array();

		$histories = $historyRepository->getLatestSearched($user);

		$englishIds = [];
		foreach($histories as $history) {
			$englishIds[] = $history->getWord()->getId();
			$resultSet[$history->getWord()->getName()] = array();
		}

		$historyByHits = $historyRepository->getSearchedByHits($user);

		$englishIds = [];
		foreach($historyByHits as $hit) {
			$englishIds[] = $hit->getWord()->getId();
			$resultHits[$hit->getWord()->getName()] = array(
				'hits' => $hit->getHits(),
				'translation' => array()
			);
		}

		$eng2srbRepository = $em->getRepository('DictionaryBundle:Eng2srb');
		$results = $eng2srbRepository->getEnglishTranslations($englishIds);

		/** @var $history History*/
		foreach($results as $result) {
			$resultSet[$result->getEng()->getName()][] = $result->getSrb()->getName();
			$resultHits[$result->getEng()->getName()]['translation'][] = $result->getSrb()->getName();
		}

        return array(
			'histories' 	=> $resultSet,
			'historyHits' 	=> $resultHits
		);
    }

	/**
	 * @Route("/translate", name="_translate")
	 * @Template("DictionaryBundle:Default:index.html.twig")
	 */
	public function matchAction(Request $request)
	{
		$word = strtolower($request->get('q'));
		if (empty($word)) {
			return $this->redirect($this->generateUrl('_home'));
		}

		$user = $this->getUser();
		/** @var  $translationManager TranslateManager */
		$translationManager = $this->get('dictionary.translateManager');
		$success = $translationManager->translate($word, $user);

		if (!$success) {
			$this->get('session')->getFlashBag()->add(
				'notice',
				'No results'
			);
		}

		return $this->redirect($this->generateUrl('_home'));
	}
}
