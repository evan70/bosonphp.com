<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncCategories;

use App\Shared\Domain\Bus\CommandId;

final readonly class SyncCategoriesCommand
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        public CommandId $id = new CommandId(),
    ) {}
}
