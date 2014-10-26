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
			->addArgument('limit', InputArgument::OPTIONAL, '')
			->addArgument('offset', InputArgument::OPTIONAL, '')
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
		$limit = $input->getArgument('limit');
		$offset = $input->getArgument('offset');

		$html = file_get_contents($url);

		$crawler = new Crawler($html);

		$content = strip_tags($crawler->filter('body')->html());
		$content = preg_replace('/[\s]+/', ' ', $content);
		$words = explode(' ', $content);

		$translationManager = $this->getContainer()->get('dictionary.translateManager');

		$limit = ($limit && 'all' != $limit) ? $limit : count($words);
		$offset = $offset ?: 0;

		$wordsFromMetak = 0;
		$wordsFromDb = 0;

		$output->writeln("<info>number of words" . $limit . "</info>");

		for($i = 0; $i < $limit; $i ++) {
			$output->writeln("<info>number index" . $i . "</info>");
			$chars = array(',', '.', ':', ' ', ';', '(', ')', '"');
			$word = str_replace($chars, '', $words[$i+$offset]);
			$word = trim($word);
			$word = preg_replace('/[\s]+/', ' ', $word);
			var_dump($word);
			if (preg_match('/[0-9]+/', $word) || strlen($word) < 3 || strlen($word) > 16){
				$output->writeln("<error>word is not valid:[$word]</error>");
				$output->writeln("<info>===================" . round($i / $limit * 100) . "% percent are processed=================</info>");
				continue;
			}
			$output->writeln("<comment>[WORD]:" . $word . "</comment>");

			$success = $translationManager->translate($word);
			if(!$success) {
				$wordsFromMetak++;
				$result = $translationManager->translateFromGoogle(strtolower($word));
				if($result['success']) {
					$output->writeln("<info>GOOGLE</info>");
				} else {
					$output->writeln("GOOGLE do not know for this word");
				}
			} else {
				$wordsFromDb++;
				$output->writeln("DB");
			}

			if($i % 30 == 0) {
				$output->writeln("<info>===================" . round($i / $limit * 100) . "% percent are processed=================</info>");
			}
		}
		$output->writeln("[words from GOOGLE]:" . $wordsFromMetak);
		$output->writeln("[words from DATABASE]:" . $wordsFromDb);
	}
}