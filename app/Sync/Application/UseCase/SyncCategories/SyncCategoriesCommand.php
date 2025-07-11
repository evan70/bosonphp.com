<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\SyncCategories;

use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

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
