<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Console;

use App\Documentation\Domain\Content\DocumentContentRendererInterface;
use App\Documentation\Domain\Document;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressIndicator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('docs:rerender')]
final class DocsRerenderCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly DocumentContentRendererInterface $renderer,
    ) {
        parent::__construct();
    }

    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $pages = $this->em->getRepository(Document::class)
            ->findAll();

        $progress = new ProgressIndicator($output);
        $progress->start('Processing...');

        foreach ($pages as $i => $page) {
            $page->content->render($this->renderer);

            $this->em->persist($page);

            $progress->advance();
        }

        $progress->finish('Done');

        $this->em->flush();

        return self::SUCCESS;
    }
}
