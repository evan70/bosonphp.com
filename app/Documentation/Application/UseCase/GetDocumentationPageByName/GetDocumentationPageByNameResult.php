<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationPageByName;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\Version\Version;

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
