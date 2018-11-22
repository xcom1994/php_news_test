<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\News;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class AddnewsCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'addnews';


    protected function configure()
    {
        $this->setDescription('Adding new news');
		
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

		$title = $io->ask('Enter title of news:',null, function ($txt) {
				if (empty($txt)) {
				throw new \RuntimeException('Title of news cannot be empty.');
			}
			return $txt;
		});
		
		$text = $io->ask('Enter text of news:',null, function ($txt) {
				if (empty($txt)) {
				throw new \RuntimeException('Text of news cannot be empty.');
			}
			return $txt;
		});		
		
		
		$entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        $news = new News();
        $news->setdate(date_create());
        $news->settitle($title);
        $news->setbody($text);

        $entityManager->persist($news);

        $entityManager->flush();

		$io->success('News added to the base');
		
	}
}
