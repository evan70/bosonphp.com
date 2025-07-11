<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncAllVersions;

use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

final readonly class SyncAllVersionsCommand
{
    public function __construct(
        public CommandId $id = new CommandId(),
    ) {}
}
