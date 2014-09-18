<?php

namespace Dictionary\DictionaryBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;


/**
 * Class NewsletterUserExportCommand
 * @package Joiz\HardcoreBundle\Command
 */
class fetchWordsCommand extends ContainerAwareCommand
{
	/**
	 * config description and arguments
	 */
	protected function configure()
	{
		$this
			->setName('fetch:word')
			->addArgument('url', InputArgument::REQUIRED, '')
			->addArgument('offset', InputArgument::REQUIRED, '')
		;
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$url = $input->getArgument('url');
		$offset = $input->getArgument('offset');
		$html = file_get_contents($url);

		$crawler = new Crawler($html);

		$content = strip_tags($crawler->filter('body')->html());
		$content = preg_replace('/[\s]+/', ' ', $content);
		$words = explode(' ', $content);

		$translationManager = $this->getContainer()->get('dictionary.translateManager');

		$limit = $offset + 150;
		$j = 0;
		$wordsFromMetak = 0;
		$wordsFromDb = 0;
		for($i = $offset; $i < $limit; $i ++) {
			$j++;
			$chars = array(',', '.', ':', ' ', ';', '(', ')', '"');
			$word = str_replace($chars, '', $words[$i]);
			$word = trim($word);
			$word = preg_replace('/[\s]+/', ' ', $word);
			if (!preg_match('/[0-9]+/', $word) && strlen($word) < 3){
				$output->writeln("<error>word is not valid:[ $word]</error>");
				continue;
			}
			$output->writeln("<comment>[WORD]:" . $words[$i] . "</comment>");

			$success = $translationManager->translate($word);
			if(!$success) {
				$wordsFromMetak++;
				$success = $translationManager->translateFromService(strtolower($words[$i]));
				if($success) {
					$output->writeln("<info>METAK</info>");
				} else {
					$output->writeln("METAK do not know for this word");
				}
			} else {
				$wordsFromDb++;
				$output->writeln("DB");
			}
			if($i % 10 == 0) {
				$output->writeln("<info>===================" . round($j / 150 * 100) . "% percent are processed=================</info>");
			}
		}
		$output->writeln("[words from metak]:" . $wordsFromMetak);
		$output->writeln("[words from DATABASE]:" . $wordsFromDb);
	}
}