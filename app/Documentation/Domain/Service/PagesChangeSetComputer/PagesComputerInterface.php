<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service\PagesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Event\PageEvent;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\Service\PageInfo;

interface PagesComputerInterface
{
    /**
     * @param array<non-empty-string, Page> $existing Existing pages in the system
     * @param array<non-empty-string, PageInfo> $updated External page data
     *
     * @return iterable<Page, PageEvent> Pairs of pages and their events
     */
    public function process(Category $category, array $existing, array $updated): iterable;
}
