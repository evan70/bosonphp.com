<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationCategoriesList;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Version;

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
