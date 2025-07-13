<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncVersions;

use App\Shared\Domain\Bus\CommandId;

final readonly class SyncVersionsCommand
{
    public function __construct(
        public CommandId $id = new CommandId(),
    ) {}
}
