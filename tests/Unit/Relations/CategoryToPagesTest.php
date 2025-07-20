<?php

declare(strict_types=1);

namespace App\Tests\Unit\Relations;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\Version\Version;

final class CategoryToPagesTest extends RelationsTestCase
{
    public function testPageReferencesCategory(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
    }

    public function testPageUniqueInCollection(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        $category->pages->add($page);
        $category->pages->add($page);
        $category->pages->add($page);
        $category->pages->add($page);

        self::assertCount(1, $category->pages);

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
    }

    public function testPageChangeCategory(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new PageDocument($category1, 'Test Page', 'test-uri', 'Test content');

        $category2->pages->add($page);

        self::assertFalse($category1->pages->contains($page));
        self::assertNotSame($page->category, $category1);

        self::assertTrue($category2->pages->contains($page));
        self::assertSame($page->category, $category2);
    }

    public function testPageCategoryPropertyChange(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new PageDocument($category1, 'Test Page', 'test-uri', 'Test content');

        // Act - Change category property directly
        $page->category = $category2;

        // Assert - Old category loses reference
        self::assertFalse($category1->pages->contains($page));
        self::assertNotSame($page->category, $category1);

        // Assert - New category gains reference
        self::assertTrue($category2->pages->contains($page));
        self::assertSame($page->category, $category2);
    }

    public function testPageRemoval(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        $category->pages->removeElement($page);

        self::assertFalse($category->pages->contains($page));
    }

    public function testMultiplePages(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page1 = new PageDocument($category, 'Page 1', 'test-uri-1', 'Content 1');
        $page2 = new PageDocument($category, 'Page 2', 'test-uri-2', 'Content 2');
        $page3 = new PageDocument($category, 'Page 3', 'test-uri-3', 'Content 3');

        $category->pages->add($page1);
        $category->pages->add($page2);
        $category->pages->add($page3);

        self::assertSame($category, $page1->category);
        self::assertSame($category, $page2->category);
        self::assertSame($category, $page3->category);
        self::assertCount(3, $category->pages);
    }

    public function testPageMoveBetweenCategories(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');
        $category3 = new Category($version, 'Category 3');

        $page = new PageDocument($category1, 'Test Page', 'test-uri', 'Test content');

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

    public function testSameCategoryNoChange(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        $initialPagesCount = $category->pages->count();

        // Act - Set same category
        $page->category = $category;

        // Assert
        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
        self::assertSame($initialPagesCount, $category->pages->count());
    }

    public function testNullCategoryThrowsException(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        // Act & Assert
        $this->expectException(\TypeError::class);
        $page->category = null;
    }

    public function testAutoAddOnCreation(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');

        $page = new PageDocument($category, 'Test Page', 'test-uri', 'Test content');

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
        self::assertCount(1, $category->pages);
    }

    public function testPropertyChangeUpdatesCollection(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');

        $page = new PageDocument($category1, 'Test Page', 'test-uri', 'Test content');

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
