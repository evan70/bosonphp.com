<?php

declare(strict_types=1);

namespace App\Tests\Unit\Relations;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Document;
use App\Documentation\Domain\Version\Version;
use PHPUnit\Framework\Attributes\TestDox;

final class CategoryToPagesTest extends RelationsTestCase
{
    #[TestDox('Page references its category')]
    public function testPageReferencesCategory(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
    }

    #[TestDox('Page is unique in category collection')]
    public function testPageUniqueInCollection(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        $category->pages->add($page);
        $category->pages->add($page);
        $category->pages->add($page);
        $category->pages->add($page);

        self::assertCount(1, $category->pages);

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
    }

    #[TestDox('Page can change its category')]
    public function testPageChangeCategory(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new Document($category1, 'Test Page', 'test-uri', 'Test content');

        $category2->pages->add($page);

        self::assertFalse($category1->pages->contains($page));
        self::assertNotSame($page->category, $category1);

        self::assertTrue($category2->pages->contains($page));
        self::assertSame($page->category, $category2);
    }

    #[TestDox('Changing page category property updates collections')]
    public function testPageCategoryPropertyChange(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new Document($category1, 'Test Page', 'test-uri', 'Test content');

        // Act - Change category property directly
        $page->category = $category2;

        // Assert - Old category loses reference
        self::assertFalse($category1->pages->contains($page));
        self::assertNotSame($page->category, $category1);

        // Assert - New category gains reference
        self::assertTrue($category2->pages->contains($page));
        self::assertSame($page->category, $category2);
    }

    #[TestDox('Page can be removed from category')]
    public function testPageRemoval(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        $category->pages->removeElement($page);

        self::assertFalse($category->pages->contains($page));
    }

    #[TestDox('Multiple pages in one category')]
    public function testMultiplePages(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page1 = new Document($category, 'Page 1', 'test-uri-1', 'Content 1');
        $page2 = new Document($category, 'Page 2', 'test-uri-2', 'Content 2');
        $page3 = new Document($category, 'Page 3', 'test-uri-3', 'Content 3');

        $category->pages->add($page1);
        $category->pages->add($page2);
        $category->pages->add($page3);

        self::assertSame($category, $page1->category);
        self::assertSame($category, $page2->category);
        self::assertSame($category, $page3->category);
        self::assertCount(3, $category->pages);
    }

    #[TestDox('Page can move between categories')]
    public function testPageMoveBetweenCategories(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');
        $category3 = new Category($version, 'Category 3');

        $page = new Document($category1, 'Test Page', 'test-uri', 'Test content');

        // Act - Move from category1 to category2
        $page->category = $category2;

        // Assert - First move
        self::assertSame($category2, $page->category);
        self::assertFalse($category1->pages->contains($page));
        self::assertTrue($category2->pages->contains($page));

        // Act - Move from category2 to category3
        $page->category = $category3;

        // Assert - Second move
        self::assertSame($category3, $page->category);
        self::assertFalse($category1->pages->contains($page));
        self::assertFalse($category2->pages->contains($page));
        self::assertTrue($category3->pages->contains($page));
    }

    #[TestDox('Setting same category does not change collection')]
    public function testSameCategoryNoChange(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        $initialPagesCount = $category->pages->count();

        // Act - Set same category
        $page->category = $category;

        // Assert
        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
        self::assertSame($initialPagesCount, $category->pages->count());
    }

    #[TestDox('Setting null category throws exception')]
    public function testNullCategoryThrowsException(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        // Act & Assert
        $this->expectException(\TypeError::class);
        $page->category = null;
    }

    #[TestDox('Page is auto-added to category on creation')]
    public function testAutoAddOnCreation(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new Document($category, 'Test Page', 'test-uri', 'Test content');

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
        self::assertCount(1, $category->pages);
    }

    #[TestDox('Changing property updates category collection')]
    public function testPropertyChangeUpdatesCollection(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new Document($category1, 'Test Page', 'test-uri', 'Test content');

        // Verify initial state
        self::assertTrue($category1->pages->contains($page));
        self::assertFalse($category2->pages->contains($page));

        // Act - Change category via property assignment
        $page->category = $category2;

        // Assert - Collections are updated
        self::assertFalse($category1->pages->contains($page));
        self::assertTrue($category2->pages->contains($page));
        self::assertSame($category2, $page->category);
    }
}
