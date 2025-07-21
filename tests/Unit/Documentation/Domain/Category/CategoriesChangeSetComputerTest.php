<?php

declare(strict_types=1);

namespace App\Tests\Unit\Documentation\Domain\Category;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryCreated;
use App\Documentation\Domain\Category\Event\CategoryUpdated;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToCreateComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToRemoveComputer;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer\CategoriesToUpdateComputer;
use App\Documentation\Domain\Category\Service\CategoryInfo;
use App\Documentation\Domain\Version\Version;
use App\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(CategoriesChangeSetComputer::class)]
final class CategoriesChangeSetComputerTest extends TestCase
{
    private CategoriesChangeSetComputer $computer;

    protected function setUp(): void
    {
        $this->computer = new CategoriesChangeSetComputer(
            new CategoriesToUpdateComputer(),
            new CategoriesToCreateComputer(),
            new CategoriesToRemoveComputer(),
        );
    }

    public function testNoChanges(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

    public function testOnlyCreate(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('cat1', $plan->created[0]->title);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(CategoryCreated::class, $plan->events[0]);
    }

    public function testOnlyUpdate(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'oldhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('cat1', $plan->updated[0]->title);
        self::assertSame('newhash', $plan->updated[0]->hash);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(CategoryUpdated::class, $plan->events[0]);
    }

    public function testCreateAndUpdate(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'oldhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
            new CategoryInfo(hash: 'hash2', name: 'cat2'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('cat2', $plan->created[0]->title);
        self::assertCount(1, $plan->updated);
        self::assertSame('cat1', $plan->updated[0]->title);
        self::assertCount(2, $plan->events);
    }

    public function testEmptyInput(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [], []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

    public function testDuplicateNames(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'oldhash');
        new Category($version, 'cat1', hash: 'oldhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
            new CategoryInfo(hash: 'hash2', name: 'cat2'),
            new CategoryInfo(hash: 'hash2', name: 'cat2'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('cat2', $plan->created[0]->title);
        self::assertSame('cat1', $plan->updated[0]->title);
    }
}
