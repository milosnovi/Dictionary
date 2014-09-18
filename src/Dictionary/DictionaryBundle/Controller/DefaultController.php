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

		$englishIds = array();
		foreach($histories as $history) {
			$englishIds[] = $history->getWord()->getId();
			$resultSet[$history->getWord()->getName()] = array();
		}
		$historyByHits = $historyRepository->getSearchedByHits($user);

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
		$word = strtolower($request->get('word'));

        return array(
			'latestSearch'	=> isset($resultSet[$word]) ? $resultSet[$word] : false,
			'latestWord'	=> $word,
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
		if(!$success) {
			$success = $translationManager->translateFromService($word, $user);
		}

		if (!$success) {
			$this->get('session')->getFlashBag()->add(
				'notice',
				'No results'
			);
		}

		return $this->redirect($this->generateUrl('_home', array('word' => $word)));
	}

	/**
	 *  @Route("/test", name="_translate1")
	 */
	public function testAction() {
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://translate.google.com/translate_a/single?client=t&sl=en&tl=sr&hl=en&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&dt=at&dt=sw&ie=UTF-8&oe=UTF-8&oc=1&otf=2&rom=1&ssel=0&tsel=0&q=play',
			CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));
		$resp = curl_exec($curl);
//		$html = '<!DOCTYPE html>
//            <html>
// 			<meta charset="UTF-8" />
//                <body>
//                    ' . $resp . '
//                </body>
//            </html>';
//		$crawler = new Crawler($html);
//		$resp = '[["noun",["igra","комад","драма","дејство","играње","мртви ход"],[["игра",["game","play","dance","playgame","blind man buff","dalliance"],,0.41039917],["комад",["piece","play","slip","shred","snippet","chunk"],,0.023153137],["драма",["drama","play"],,0.011461634],["дејство",["action","effect","influence","play"]],["играње",["playing","dancing","play","personation"]],["мртви ход",["backlash","play"]]],"play",1],["verb",["играти","глумити","играти се","одиграти","одсвирати","свирати"],[["играти",["play","dance","act","perform","twitch","take"],,0.25682124],["глумити",["play","act","playact","do"]],["играти се",["play","toy","fool around","monkey","niggle","play at"]],["одиграти",["play","enact","finish","dance"]],["одсвирати",["play","pipe"]],["свирати",["play","perform"]]],"play",2]],"en",,[["плаи",[1],true,false,1000,0,1,0]],[["play",1,[["плаи",1000,true,false],["играти",0,true,false],["играју",0,true,false],["игра",0,true,false],["играте",0,true,false]],[[0,4]],"play"]],,,[["en"],,[0.73333335]],,,[["noun",[[["amusement","entertainment","relaxation","recreation","diversion","distraction","leisure","enjoyment","pleasure","fun","games","fun and games","horseplay","merrymaking","revelry","living it up"],"m_en_us1278708.032"],[["drama","theatrical work","screenplay","comedy","tragedy","production","performance","show","sketch"],"m_en_us1278708.041"],[["action","activity","operation","working","function","interaction","interplay"],"m_en_us1278708.038"],[["behavior","goings-on","activity","action","deed"],""],[["movement","slack","give","room to maneuver","scope","latitude"],"m_en_us1278708.042"],[["looseness"],""],[["gambling","gaming"],""],[["drama"],""],[["frolic","caper","gambol","romp"],""],[["turn"],""],[["shimmer"],""],[["free rein"],""],[["sport","fun"],""],[["bid"],""],[["swordplay"],""],[["maneuver"],""],[["child lay"],""]],"play"],["verb",[[["amuse oneself","entertain oneself","enjoy oneself","have fun","relax","occupy oneself","divert oneself","frolic","frisk","romp","caper","mess around"]]';
		preg_match_all('/noun\"\,\[(\W*)\]/', $resp, $out);
		var_dump($out);
		exit;
		var_dump($out[1][0]);
		$noun = $out[1][0];
		$nounArr = explode(',', $noun);
		var_dump($nounArr);
		$t = \Transliterator::create('Serbian-Latin/BGN');
		foreach($nounArr as $noun) {
			var_dump($t->transliterate($noun));
			exit;
		}
		exit;

	}
}
