<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersions;

use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

final readonly class SyncVersionsCommand
{
    public function __construct(
        public CommandId $id = new CommandId(),
    ) {}
}
