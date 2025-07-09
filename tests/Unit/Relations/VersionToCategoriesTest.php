<?php

declare(strict_types=1);

namespace App\Tests\Unit\Relations;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Version;

final class VersionToCategoriesTest extends RelationsTestCase
{
    public function testCategoryReferencesVersion(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        self::assertSame($version, $category->version);
        self::assertTrue($version->categories->contains($category));
    }

    public function testCategoryUniqueInCollection(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $version->categories->add($category);
        $version->categories->add($category);
        $version->categories->add($category);
        $version->categories->add($category);

        self::assertCount(1, $version->categories);

        self::assertSame($version, $category->version);
        self::assertTrue($version->categories->contains($category));
    }

    public function testCategoryChangeVersion(): void
    {
        $version1 = new Version('v1.0');
        $version2 = new Version('v2.0');

        $category = new Category($version1, 'Test Category');

        $version2->categories->add($category);

        self::assertFalse($version1->categories->contains($category));
        self::assertNotSame($category->version, $version1);

        self::assertTrue($version2->categories->contains($category));
        self::assertSame($category->version, $version2);
    }

    public function testCategoryVersionPropertyChange(): void
    {
        $version1 = new Version('v1.0');
        $version2 = new Version('v2.0');

        $category = new Category($version1, 'Test Category');

        // Act - Change version property directly
        $category->version = $version2;

        // Assert - Old version loses reference
        self::assertFalse($version1->categories->contains($category));
        self::assertNotSame($category->version, $version1);

        // Assert - New version gains reference
        self::assertTrue($version2->categories->contains($category));
        self::assertSame($category->version, $version2);
    }

    public function testCategoryRemoval(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $version->categories->removeElement($category);

        self::assertFalse($version->categories->contains($category));
    }

    public function testMultipleCategories(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');
        $category3 = new Category($version, 'Category 3');

        $version->categories->add($category1);
        $version->categories->add($category2);
        $version->categories->add($category3);

        self::assertSame($version, $category1->version);
        self::assertSame($version, $category2->version);
        self::assertSame($version, $category3->version);
        self::assertCount(3, $version->categories);
    }

    public function testCategoryMoveBetweenVersions(): void
    {
        $version1 = new Version('v1.0');
        $version2 = new Version('v2.0');
        $version3 = new Version('v3.0');

        $category = new Category($version1, 'Test Category');

        // Act - Move from version1 to version2
        $category->version = $version2;

        // Assert - First move
        self::assertSame($version2, $category->version);
        self::assertFalse($version1->categories->contains($category));
        self::assertTrue($version2->categories->contains($category));

        // Act - Move from version2 to version3
        $category->version = $version3;

        // Assert - Second move
        self::assertSame($version3, $category->version);
        self::assertFalse($version1->categories->contains($category));
        self::assertFalse($version2->categories->contains($category));
        self::assertTrue($version3->categories->contains($category));
    }

    public function testSameVersionNoChange(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $initialCategoriesCount = $version->categories->count();

        // Act - Set same version
        $category->version = $version;

        // Assert
        self::assertSame($version, $category->version);
        self::assertTrue($version->categories->contains($category));
        self::assertSame($initialCategoriesCount, $version->categories->count());
    }

    public function testNullVersionThrowsException(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        // Act & Assert
        $this->expectException(\TypeError::class);
        $category->version = null;
    }

    public function testAutoAddOnCreation(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        self::assertSame($version, $category->version);
        self::assertTrue($version->categories->contains($category));
        self::assertCount(1, $version->categories);
    }

    public function testPropertyChangeUpdatesCollection(): void
    {
        $version1 = new Version('v1.0');
        $version2 = new Version('v2.0');

        $category = new Category($version1, 'Test Category');

        // Verify initial state
        self::assertTrue($version1->categories->contains($category));
        self::assertFalse($version2->categories->contains($category));

        // Act - Change version via property assignment
        $category->version = $version2;

        // Assert - Collections are updated
        self::assertFalse($version1->categories->contains($category));
        self::assertTrue($version2->categories->contains($category));
        self::assertSame($version2, $category->version);
    }
}
