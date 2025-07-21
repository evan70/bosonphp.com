<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service\PagesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Document;
use App\Documentation\Domain\Event\DocumentRemoved;
use App\Documentation\Domain\Event\LinkRemoved;
use App\Documentation\Domain\Link;

final readonly class PagesToRemoveComputer implements PagesComputerInterface
{
    public function process(Category $category, array $existing, array $updated): iterable
    {
        foreach ($category->pages as $page) {
            // Fetch updated entity from index
            $updatedPage = $updated[$page->uri] ?? null;

            // Skip in case of page is present
            if ($updatedPage !== null) {
                continue;
            }

            yield $page => match (true) {
                $page instanceof Document => new DocumentRemoved(
                    version: $category->version->name,
                    category: $category->title,
                    title: $page->title,
                    uri: $page->uri,
                    content: $page->content->value,
                ),
                $page instanceof Link => new LinkRemoved(
                    version: $category->version->name,
                    category: $category->title,
                    title: $page->title,
                    uri: $page->uri,
                ),
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported page type %s',
                    $page::class,
                )),
            };
        }
    }
}
