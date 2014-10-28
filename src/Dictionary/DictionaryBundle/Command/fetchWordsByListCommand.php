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
class fetchWordsByListCommand extends ContainerAwareCommand
{
	/**
	 * config description and arguments
	 */
	protected function configure()
	{
		$this
			->setName('fetch:wordList')
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
		// 11000
		$limit = $input->getArgument('limit');
		$offset = $input->getArgument('offset');

		$translationManager = $this->getContainer()->get('dictionary.translateManager');

		$kernelRootDir = $this->getContainer()->getParameter('kernel.root_dir');
		$txt_file = file_get_contents($kernelRootDir . '/../bin/translation_example/english_words_II.txt');
		$rows = explode("\n", $txt_file);

		$wordsFromGoogle = 0;
		$wordsFailsFromGoogle = 0;
		$wordsFromDb = 0;

		$limit = ($limit && 'all' != $limit) ? $limit : count($rows);
		$offset = $offset ?: 0;

		for ($i = 0; $i < $limit; $i++) {
			$output->writeln("<info>number index " . $i . "</info>");
			$output->writeln("<comment>[WORD]:" . $rows[$i + $offset] . "</comment>");

			$success = $translationManager->translate($rows[$i + $offset]);
			if (!$success) {
				$result = $translationManager->translateFromGoogle(strtolower($rows[$i + $offset]));
				if ($result['success']) {
					$wordsFromGoogle++;
					$output->writeln("<info>GOOGLE</info>");
				} else {
					$wordsFailsFromGoogle++;
					$output->writeln("GOOGLE do not know for this word");
				}
			} else {
				$wordsFromDb++;
				$output->writeln("DB");
			}

			if ($i % 30 == 0) {
				$output->writeln("<info>===================" . round($i / $limit * 100) . "% percent are processed=================</info>");
				$output->writeln("[words from GOOGLE]:" . $wordsFromGoogle);
				$output->writeln("[words fails from Google]:" . $wordsFailsFromGoogle);
				$output->writeln("[words from DATABASE]:" . $wordsFromDb);
				$output->writeln("<info>===================>===================>===================>===============================</info>");
			}
		}

	}
}