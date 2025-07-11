<?php

declare(strict_types=1);

namespace App\Sync\Presentation\Console;

use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Application\UseCase\SyncVersions\SyncVersionsCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand('sync:docs')]
final class DocsUpdateCommand extends Command
{
    public function __construct(
        private readonly CommandBusInterface $commands,
    ) {
        parent::__construct();
    }

    public function __invoke(): int
    {
        $this->commands->send(new SyncVersionsCommand());

        return self::SUCCESS;
    }
}
