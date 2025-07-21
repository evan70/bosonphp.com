<?php

declare(strict_types=1);

namespace App\Tests\Unit\Documentation\Domain\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Document;
use App\Documentation\Domain\Event\DocumentCreated;
use App\Documentation\Domain\Event\DocumentUpdated;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageTitleExtractorInterface;
use App\Documentation\Domain\Service\DocumentInfo;
use App\Documentation\Domain\Service\PagesChangeSetComputer;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToCreateComputer;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToRemoveComputer;
use App\Documentation\Domain\Service\PagesChangeSetComputer\PagesToUpdateComputer;
use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Sync\Application\Output\ExternalDocumentOutput;
use App\Sync\Application\UseCase\GetExternalDocumentByName\GetExternalDocumentByNameOutput;
use App\Sync\Domain\ExternalDocument;
use App\Sync\Domain\ExternalPageId;
use App\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use App\Documentation\Domain\Service\LinkInfo;
use App\Documentation\Domain\Link;
use App\Documentation\Domain\Event\LinkCreated;
use App\Documentation\Domain\Event\LinkUpdated;
use App\Documentation\Domain\Event\LinkRemoved;

#[CoversClass(PagesChangeSetComputer::class)]
final class PagesChangeSetComputerTest extends TestCase
{
    private readonly PagesChangeSetComputer $computer;
    private readonly QueryBusInterface $queryBus;
    private readonly PageTitleExtractorInterface $titleExtractor;

    #[Before(priority: 1)]
    protected function setUpTitleExtractor(): void
    {
        $this->titleExtractor = $this->createStub(PageTitleExtractorInterface::class);

        $this->titleExtractor->method('extractTitle')
            ->willReturnCallback(fn(Page $page): string => $page->title);
    }

    #[Before(priority: 1)]
    protected function setUpQueryBus(): void
    {
        $this->queryBus = $this->createMock(QueryBusInterface::class);

        $this->queryBus->method('get')
            ->willReturnCallback(function (object $query): GetExternalDocumentByNameOutput {
                return new GetExternalDocumentByNameOutput(
                    ExternalDocumentOutput::fromExternalDocument(
                        new ExternalDocument(
                            id: ExternalPageId::createFromVersionAndPath('v1.0', 'doc1'),
                            hash: 'hash1',
                            path: 'doc1',
                            content: 'content',
                        ),
                    ),
                );
            });
    }

    #[Before]
    protected function setUpPagesChangeSetComputer(): void
    {
        $this->computer = new PagesChangeSetComputer(
            new PagesToUpdateComputer($this->titleExtractor, $this->queryBus),
            new PagesToCreateComputer($this->titleExtractor, $this->queryBus),
            new PagesToRemoveComputer(),
        );
    }

    private function createVersion(): Version
    {
        return new Version(
            name: 'v1.0',
            status: Status::DEFAULT,
        );
    }

    private function createCategory(): Category
    {
        return new Category(
            version: $this->createVersion(),
            title: 'Example Category',
            description: null,
            icon: null,
            order: 0,
        );
    }

    #[TestDox('No changes if all pages match by uri and hash')]
    public function testNoChanges(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('hash1', 'uri1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->removed);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Creates page if it does not exist')]
    public function testOnlyCreate(): void
    {
        $category = $this->createCategory();

        $plan = $this->computer->compute($category, [
            new DocumentInfo('hash1', 'doc1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('doc1', $plan->created[0]->title);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(DocumentCreated::class, $plan->events[0]);
    }

    #[TestDox('Updates page if hash changes')]
    public function testOnlyUpdate(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'old_hash');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('new_hash', 'uri1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('doc1', $plan->updated[0]->title);
        self::assertSame('new_hash', $plan->updated[0]->hash);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(DocumentUpdated::class, $plan->events[0]);
    }

    #[TestDox('Creates and updates pages simultaneously')]
    public function testCreateAndUpdate(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'old_hash');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('new_hash', 'uri1'),
            new DocumentInfo('hash2', 'uri2'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('uri2', $plan->created[0]->title);
        self::assertCount(1, $plan->updated);
        self::assertSame('doc1', $plan->updated[0]->title);
        self::assertCount(0, $plan->removed);
        self::assertCount(2, $plan->events);
    }

    #[TestDox('No changes for empty input')]
    public function testEmptyInput(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');

        $plan = $this->computer->compute($category, []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->removed);
        self::assertCount(1, $plan->events);
    }

    #[TestDox('Handles duplicate page names in input and existing')]
    public function testDuplicateNames(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'old_hash');
        new Document($category, 'doc1', 'uri1', '', 0, 'old_hash');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('new_hash', 'uri1'),
            new DocumentInfo('hash2', 'uri2'),
            new DocumentInfo('hash2', 'uri2'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('uri2', $plan->created[0]->title);
        self::assertSame('doc1', $plan->updated[0]->title);
    }

    #[TestDox('Order of input does not affect result')]
    public function testOrderOfInputDoesNotAffectResult(): void
    {
        $category1 = $this->createCategory();

        new Document($category1, 'doc1', 'uri1', '', 0, 'old_hash');
        new Document($category1, 'doc2', 'uri2', '', 0, 'old_hash2');

        $plan1 = $this->computer->compute($category1, [
            new DocumentInfo('new_hash', 'uri1'),
            new DocumentInfo('hash2', 'uri2'),
        ]);

        $category2 = $this->createCategory();

        new Document($category2, 'doc2', 'uri2', '', 0, 'old_hash2');
        new Document($category2, 'doc1', 'uri1', '', 0, 'old_hash');

        $plan2 = $this->computer->compute($category2, [
            new DocumentInfo('hash2', 'doc2'),
            new DocumentInfo('new_hash', 'doc1'),
        ]);

        $names1 = [$plan1->updated[0]->title, $plan1->created[0]->title];
        $names2 = [$plan2->updated[0]->title, $plan2->created[0]->title];

        \sort($names1);
        \sort($names2);

        self::assertSame($names1, $names2);
    }

    #[TestDox('Removes only one of multiple pages')]
    public function testRemoveOnlyOneOfMultiplePages(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');
        new Document($category, 'doc2', 'uri2', '', 0, 'hash2');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('hash1', 'uri1'),
        ]);

        self::assertCount(1, $plan->removed);
        self::assertSame('doc2', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate names in removed pages')]
    public function testDuplicateNamesInRemoved(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');
        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');

        $plan = $this->computer->compute($category, []);

        self::assertCount(1, $plan->removed);
        self::assertSame('doc1', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate names in created pages')]
    public function testDuplicateNamesInCreated(): void
    {
        $category = $this->createCategory();

        $plan = $this->computer->compute($category, [
            new DocumentInfo('hash1', 'uri1'),
            new DocumentInfo('hash1', 'uri1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('uri1', $plan->created[0]->title);
    }

    #[TestDox('Removes and updates simultaneously')]
    public function testRemoveAndUpdateSimultaneously(): void
    {
        $category = $this->createCategory();

        new Document($category, 'doc1', 'uri1', '', 0, 'hash1');
        new Document($category, 'doc2', 'uri2', '', 0, 'hash2');

        $plan = $this->computer->compute($category, [
            new DocumentInfo('new_hash', 'uri1'),
        ]);

        self::assertCount(1, $plan->updated);
        self::assertSame('doc1', $plan->updated[0]->title);
        self::assertCount(1, $plan->removed);
        self::assertSame('doc2', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate names with different hash in input')]
    public function testDuplicateNamesWithDifferentHash(): void
    {
        $category = $this->createCategory();

        $plan = $this->computer->compute($category, [
            new DocumentInfo('hash1', 'uri1'),
            new DocumentInfo('hash2', 'uri1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('uri1', $plan->created[0]->title);
    }

    #[TestDox('Creates link if it does not exist')]
    public function testOnlyCreateLink(): void
    {
        $category = $this->createCategory();

        $plan = $this->computer->compute($category, [
            new LinkInfo('hash1', 'link1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertInstanceOf(Link::class, $plan->created[0]);
        self::assertSame('link1', $plan->created[0]->title);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(LinkCreated::class, $plan->events[0]);
    }

    #[TestDox('Updates link if hash changes')]
    public function testOnlyUpdateLink(): void
    {
        $category = $this->createCategory();

        new Link($category, 'link1', 'link1', 0, 'old_hash');

        $plan = $this->computer->compute($category, [
            new LinkInfo('new_hash', 'link1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertInstanceOf(Link::class, $plan->updated[0]);
        self::assertSame('link1', $plan->updated[0]->title);
        self::assertSame('new_hash', $plan->updated[0]->hash);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(LinkUpdated::class, $plan->events[0]);
    }

    #[TestDox('Removes link if missing in input')]
    public function testRemoveLink(): void
    {
        $category = $this->createCategory();

        new Link($category, 'link1', 'link1', 0, 'hash1');

        $plan = $this->computer->compute($category, []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->removed);
        self::assertInstanceOf(Link::class, $plan->removed[0]);
        self::assertSame('link1', $plan->removed[0]->title);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(LinkRemoved::class, $plan->events[0]);
    }

    #[TestDox('Handles duplicate link uris in input and existing')]
    public function testDuplicateLinks(): void
    {
        $category = $this->createCategory();

        new Link($category, 'link1', 'link1', 0, 'old_hash');
        new Link($category, 'link1', 'link1', 0, 'old_hash');

        $plan = $this->computer->compute($category, [
            new LinkInfo('new_hash', 'link1'),
            new LinkInfo('hash2', 'link2'),
            new LinkInfo('hash2', 'link2'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('link2', $plan->created[0]->title);
        self::assertSame('link1', $plan->updated[0]->title);
    }

    #[TestDox('Order of input does not affect result for links')]
    public function testOrderOfInputDoesNotAffectResultForLinks(): void
    {
        $category1 = $this->createCategory();

        new Link($category1, 'link1', 'link1', 0, 'old_hash');
        new Link($category1, 'link2', 'link2', 0, 'old_hash2');

        $plan1 = $this->computer->compute($category1, [
            new LinkInfo('new_hash', 'link1'),
            new LinkInfo('hash2', 'link2'),
        ]);

        $category2 = $this->createCategory();
        new Link($category2, 'link2', 'link2', 0, 'old_hash2');
        new Link($category2, 'link1', 'link1', 0, 'old_hash');

        $plan2 = $this->computer->compute($category2, [
            new LinkInfo('hash2', 'link2'),
            new LinkInfo('new_hash', 'link1'),
        ]);

        $names1 = [$plan1->updated[0]->title, $plan1->created[0]->title];
        $names2 = [$plan2->updated[0]->title, $plan2->created[0]->title];

        \sort($names1);
        \sort($names2);

        self::assertSame($names1, $names2);
    }

    #[TestDox('Removes and updates links simultaneously')]
    public function testRemoveAndUpdateLinksSimultaneously(): void
    {
        $category = $this->createCategory();

        new Link($category, 'link1', 'link1', 0, 'hash1');
        new Link($category, 'link2', 'link2', 0, 'hash2');

        $plan = $this->computer->compute($category, [
            new LinkInfo('new_hash', 'link1'),
        ]);

        self::assertCount(1, $plan->updated);
        self::assertSame('link1', $plan->updated[0]->title);
        self::assertCount(1, $plan->removed);
        self::assertSame('link2', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate uris with different hash in input for links')]
    public function testDuplicateLinksWithDifferentHash(): void
    {
        $category = $this->createCategory();

        $plan = $this->computer->compute($category, [
            new LinkInfo('hash1', 'link1'),
            new LinkInfo('hash2', 'link1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('link1', $plan->created[0]->title);
    }
}
