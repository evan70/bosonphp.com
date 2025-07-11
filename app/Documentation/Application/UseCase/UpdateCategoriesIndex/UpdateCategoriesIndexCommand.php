<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategoriesIndex;

use App\Documentation\Application\UseCase\UpdateCategoriesIndex\UpdateCategoriesIndexCommand\IndexCategory;
use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

final readonly class UpdateCategoriesIndexCommand
{
    /**
     * @var list<IndexCategory>
     */
    public array $categories;

    /**
     * @param non-empty-string $version
     * @param iterable<array-key, IndexCategory> $categories
     */
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        iterable $categories = [],
        public CommandId $id = new CommandId(),
    ) {
        $this->categories = \iterator_to_array($categories, false);
    }
}
