<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationCategoriesList;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\Version\Version;

final readonly class GetDocumentationCategoriesListResult
{
    /**
     * @var list<Category>
     */
    public array $categories;

    /**
     * @param iterable<mixed, Category> $categories
     */
    public function __construct(
        public Version $version,
        iterable $categories,
    ) {
        $this->categories = \iterator_to_array($categories, false);
    }
}
