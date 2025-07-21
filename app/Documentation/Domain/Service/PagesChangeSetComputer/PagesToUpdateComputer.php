<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service\PagesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Document;
use App\Documentation\Domain\Event\DocumentEvent;
use App\Documentation\Domain\Event\DocumentUpdated;
use App\Documentation\Domain\Event\LinkEvent;
use App\Documentation\Domain\Event\LinkUpdated;
use App\Documentation\Domain\Link;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageTitleExtractorInterface;
use App\Documentation\Domain\Service\DocumentInfo;
use App\Documentation\Domain\Service\LinkInfo;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameQuery;

final readonly class PagesToUpdateComputer implements PagesComputerInterface
{
    public function __construct(
        private PageTitleExtractorInterface $titleExtractor,
        private QueryBusInterface $queries,
    ) {}

    /**
     * Determines which pages are missing in the system and should be created.
     */
    public function process(Category $category, array $existing, array $updated): iterable
    {
        $index = 0;

        foreach ($updated as $uri => $info) {
            $order = \min($index++, 32767);

            // Fetch stored entity from index
            $existingPage = $existing[$uri] ?? null;

            // Skip in case of page is not defined
            if ($existingPage === null) {
                continue;
            }

            // Skip in case of hash is identical
            if ($info->hash === $existingPage->hash) {
                continue;
            }

            yield from match (true) {
                $info instanceof DocumentInfo => $this->updateDocument($order, $category, $existingPage, $info),
                $info instanceof LinkInfo => $this->updateLink($order, $category, $existingPage, $info),
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported page type %s',
                    $info::class,
                )),
            };
        }
    }

    /**
     * @param int<0, 32767> $order
     * @return iterable<Document, DocumentEvent>
     */
    private function updateDocument(int $order, Category $category, Page $document, DocumentInfo $info): iterable
    {
        if (!$document instanceof Document) {
            throw new \LogicException(\sprintf(
                'Could not change page type from %s to document',
                $document::class,
            ));
        }

        $document->order = $order;
        $document->hash = $info->hash;
        $document->content = $this->getDocumentContent($category->version, $info->path);

        yield $document => new DocumentUpdated(
            version: $category->version->name,
            category: $category->title,
            title: $document->title,
            uri: $document->uri,
            content: $document->content->value,
        );
    }

    /**
     * @param int<0, 32767> $order
     * @return iterable<Link, LinkEvent>
     */
    private function updateLink(int $order, Category $category, Page $link, LinkInfo $info): iterable
    {
        if (!$link instanceof Link) {
            throw new \LogicException(\sprintf(
                'Could not change page type from %s to link',
                $link::class,
            ));
        }

        // Update link title
        $link->order = $order;
        $link->hash = $info->hash;
        $link->title = $this->titleExtractor->extractTitle($link);

        yield $link => new LinkUpdated(
            version: $category->version->name,
            category: $category->title,
            title: $link->title,
            uri: $link->uri,
        );
    }

    /**
     * @param non-empty-string $path
     */
    private function getDocumentContent(Version $version, string $path): string
    {
        /** @var GetExternalDocumentByNameOutput $result */
        $result = $this->queries->get(new GetExternalDocumentByNameQuery(
            version: $version->name,
            path: $path,
        ));

        return $result->document->content;
    }
}
