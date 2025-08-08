<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service\PagesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Document;
use App\Documentation\Domain\Event\DocumentCreated;
use App\Documentation\Domain\Event\DocumentEvent;
use App\Documentation\Domain\Event\LinkCreated;
use App\Documentation\Domain\Event\LinkEvent;
use App\Documentation\Domain\Link;
use App\Documentation\Domain\PageTitleExtractorInterface;
use App\Documentation\Domain\Service\DocumentInfo;
use App\Documentation\Domain\Service\LinkInfo;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameQuery;

final readonly class PagesToCreateComputer implements PagesComputerInterface
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

            // Skip in case of page is present
            if ($existingPage !== null) {
                continue;
            }

            yield from match (true) {
                $info instanceof DocumentInfo => $this->createDocument($order, $category, $info, $uri),
                $info instanceof LinkInfo => $this->createLink($order, $category, $info),
                default => throw new \InvalidArgumentException(\sprintf(
                    'Unsupported page type %s',
                    $info::class,
                )),
            };
        }
    }

    /**
     * @param int<0, 32767> $order
     * @param non-empty-string $uri
     *
     * @return iterable<Document, DocumentEvent>
     */
    private function createDocument(int $order, Category $category, DocumentInfo $info, string $uri): iterable
    {
        $document = new Document(
            category: $category,
            title: $info->path,
            uri: $uri,
            order: $order,
            hash: $info->hash,
        );

        $document->content = $this->getDocumentContent($category->version, $info->path);
        $document->title = $this->titleExtractor->extractTitle($document);

        yield $document => new DocumentCreated(
            version: $category->version->name,
            category: $category->title,
            title: $document->title,
            uri: $document->uri,
            content: $document->content->value,
        );
    }

    /**
     * @param int<0, 32767> $order
     *
     * @return iterable<Link, LinkEvent>
     */
    private function createLink(int $order, Category $category, LinkInfo $info): iterable
    {
        $link = new Link(
            category: $category,
            title: $info->uri,
            uri: $info->uri,
            order: $order,
            hash: $info->hash,
        );

        $link->title = $this->titleExtractor->extractTitle($link);

        yield $link => new LinkCreated(
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
