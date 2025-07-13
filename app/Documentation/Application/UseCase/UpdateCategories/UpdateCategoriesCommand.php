<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories;

use App\Documentation\Application\UseCase\UpdateCategories\UpdateCategoriesCommand\CategoryIndex;
use App\Shared\Domain\Bus\CommandId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class UpdateCategoriesCommand
{
    /**
     * @var list<CategoryIndex>
     */
    public array $categories;

    /**
     * @param non-empty-string $version
     * @param iterable<array-key, CategoryIndex> $categories
     */
    public function __construct(
        /**
         * @var non-empty-string
         */
        #[NotBlank]
        public string $version,
        iterable $categories = [],
        public CommandId $id = new CommandId(),
    ) {
        $this->categories = \iterator_to_array($categories, false);
    }
}
