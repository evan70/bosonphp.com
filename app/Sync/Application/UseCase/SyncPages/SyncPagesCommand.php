<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncPages;

use App\Shared\Domain\Bus\CommandId;

final readonly class SyncPagesCommand
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $category,
        public CommandId $id = new CommandId(),
    ) {}
}
