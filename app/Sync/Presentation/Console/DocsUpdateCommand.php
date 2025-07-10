<?php

declare(strict_types=1);

namespace App\Sync\Presentation\Console;

use App\Sync\Domain\DownloaderInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand('sync:docs')]
final class DocsUpdateCommand extends Command
{
    public function __construct(
        private readonly DownloaderInterface $downloader,
    ) {
        parent::__construct();
    }

    public function __invoke(): int
    {
        dd($this->downloader);

        return self::SUCCESS;
    }
}
