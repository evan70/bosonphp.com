<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationPageByName;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\Version\Version;

final readonly class GetDocumentationPageByNameResult
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
        public PageDocument $page,
    ) {
        $this->categories = \iterator_to_array($categories, false);
    }
}
