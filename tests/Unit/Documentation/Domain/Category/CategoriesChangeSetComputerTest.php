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
use PHPUnit\Framework\Attributes\TestDox;

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

    #[TestDox('No changes if all categories match by name and hash')]
    public function testNoChanges(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->removed);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Creates category if it does not exist')]
    public function testOnlyCreate(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('cat1', $plan->created[0]->title);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(CategoryCreated::class, $plan->events[0]);
    }

    #[TestDox('Updates category if hash changes')]
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
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(CategoryUpdated::class, $plan->events[0]);
    }

    #[TestDox('Creates and updates categories simultaneously')]
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
        self::assertCount(0, $plan->removed);
        self::assertCount(2, $plan->events);
    }

    #[TestDox('No changes for empty input')]
    public function testEmptyInput(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');

        $plan = $this->computer->compute($version, []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->removed);
        self::assertCount(1, $plan->events);
    }

    #[TestDox('Handles duplicate category names in input and existing')]
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

    #[TestDox('Order of input does not affect result')]
    public function testOrderOfInputDoesNotAffectResult(): void
    {
        $version1 = new Version('v1.0', hash: 'verhash');

        new Category($version1, 'cat1', hash: 'oldhash');
        new Category($version1, 'cat2', hash: 'oldhash2');

        $plan1 = $this->computer->compute($version1, [
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
            new CategoryInfo(hash: 'hash2', name: 'cat2'),
        ]);

        $version2 = new Version('v1.0', hash: 'verhash');
        new Category($version2, 'cat2', hash: 'oldhash2');
        new Category($version2, 'cat1', hash: 'oldhash');

        $plan2 = $this->computer->compute($version2, [
            new CategoryInfo(hash: 'hash2', name: 'cat2'),
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
        ]);

        $names1 = [$plan1->updated[0]->title, $plan1->created[0]->title];
        $names2 = [$plan2->updated[0]->title, $plan2->created[0]->title];

        \sort($names1);
        \sort($names2);

        self::assertSame($names1, $names2);
    }

    #[TestDox('No update if only description changes')]
    public function testNoUpdateIfOnlyDescriptionChanges(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', description: 'desc1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1', description: 'desc2'),
        ]);

        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->removed);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Updates category if hash changes even if description same')]
    public function testUpdateIfHashChangesEvenIfDescriptionSame(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', description: 'desc1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash2', name: 'cat1', description: 'desc1'),
        ]);

        self::assertCount(1, $plan->updated);
        self::assertSame('cat1', $plan->updated[0]->title);
        self::assertSame('hash2', $plan->updated[0]->hash);
        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(CategoryUpdated::class, $plan->events[0]);
    }

    #[TestDox('No create or update if category missing in updated')]
    public function testNoCreateOrUpdateIfCategoryMissingInUpdated(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');

        $plan = $this->computer->compute($version, []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->removed);
        self::assertCount(1, $plan->events);
    }

    #[TestDox('Removes only one of multiple categories')]
    public function testRemoveOnlyOneOfMultipleCategories(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');
        new Category($version, 'cat2', hash: 'hash2');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->removed);
        self::assertSame('cat2', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate names in removed categories')]
    public function testDuplicateNamesInRemoved(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');
        new Category($version, 'cat1', hash: 'hash1');

        $plan = $this->computer->compute($version, []);

        self::assertCount(1, $plan->removed);
        self::assertSame('cat1', $plan->removed[0]->title);
    }

    #[TestDox('Handles duplicate names in created categories')]
    public function testDuplicateNamesInCreated(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('cat1', $plan->created[0]->title);
    }

    #[TestDox('Removes and updates simultaneously')]
    public function testRemoveAndUpdateSimultaneously(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', hash: 'hash1');
        new Category($version, 'cat2', hash: 'hash2');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'newhash', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->updated);
        self::assertSame('cat1', $plan->updated[0]->title);
        self::assertCount(1, $plan->removed);
        self::assertSame('cat2', $plan->removed[0]->title);
    }

    #[TestDox('No update if only icon changes')]
    public function testNoUpdateIfOnlyIconChanges(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', icon: 'icon1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1', icon: 'icon2'),
        ]);

        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->removed);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Updates category if hash changes even if icon same')]
    public function testUpdateIfHashChangesEvenIfIconSame(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        new Category($version, 'cat1', icon: 'icon1', hash: 'hash1');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash2', name: 'cat1', icon: 'icon1'),
        ]);

        self::assertCount(1, $plan->updated);
        self::assertSame('cat1', $plan->updated[0]->title);
        self::assertSame('hash2', $plan->updated[0]->hash);
        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->removed);
        self::assertCount(1, $plan->events);
    }

    #[TestDox('Handles null description and icon')]
    public function testNullDescriptionAndIconHandled(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1', description: null, icon: null),
        ]);

        self::assertCount(1, $plan->created);
        self::assertNull($plan->created[0]->description);
        self::assertNull($plan->created[0]->icon);
    }

    #[TestDox('Handles duplicate names with different hash in input')]
    public function testDuplicateNamesWithDifferentHash(): void
    {
        $version = new Version('v1.0', hash: 'verhash');

        $plan = $this->computer->compute($version, [
            new CategoryInfo(hash: 'hash1', name: 'cat1'),
            new CategoryInfo(hash: 'hash2', name: 'cat1'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('cat1', $plan->created[0]->title);
    }
}
