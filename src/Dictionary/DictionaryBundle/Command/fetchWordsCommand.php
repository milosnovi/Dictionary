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
		$html = file_get_contents($url);

		$crawler = new Crawler($html);

		$content = strip_tags($crawler->filter('body')->html());
		$content = preg_replace('/[\s]+/', ' ', $content);
		$words = explode(' ', $content);

		$translationManager = $this->getContainer()->get('dictionary.translateManager');
		var_dump(count($words));
		for($i = 0; $i < count($words); $i ++) {
			if ($i == 2000) {
				exit;
			}
			$chars = array(',', '.', ':', ' ', ';');
			$word = str_replace($chars, '', $words[$i]);
			$word = trim($word);
			$word = preg_replace('/[\s]+/', ' ', $word);
			var_dump($word);
//			$success = $translationManager->translate($words[$i]);
		}

	}
}
