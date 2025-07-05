<?php

declare(strict_types=1);

namespace App\Tests\Unit\Relations;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\PageDocumentContentRendererInterface;
use App\Domain\Documentation\PageSlugGeneratorInterface;
use App\Domain\Documentation\Version\Version;

final class CategoryToPagesTest extends RelationsTestCase
{
    public function testPageReferencesCategory(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
    }

    public function testPageUniqueInCollection(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category1, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category1, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

        $category->pages->removeElement($page);

        self::assertFalse($category->pages->contains($page));
    }

    public function testMultiplePages(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page1 = new PageDocument($category, 'Page 1', $slugGenerator, 'Content 1', $contentRenderer);
        $page2 = new PageDocument($category, 'Page 2', $slugGenerator, 'Content 2', $contentRenderer);
        $page3 = new PageDocument($category, 'Page 3', $slugGenerator, 'Content 3', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category1, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

        // Act & Assert
        $this->expectException(\TypeError::class);
        $page->category = null;
    }

    public function testAutoAddOnCreation(): void
    {
        $version = new Version('v1.0');
        $category = new Category($version, 'Test Category');
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

        self::assertSame($category, $page->category);
        self::assertTrue($category->pages->contains($page));
        self::assertCount(1, $category->pages);
    }

    public function testPropertyChangeUpdatesCollection(): void
    {
        $version = new Version('v1.0');
        $category1 = new Category($version, 'Category 1');
        $category2 = new Category($version, 'Category 2');
        $slugGenerator = $this->createMock(PageSlugGeneratorInterface::class);
        $slugGenerator->method('createSlug')->willReturn('test-page');
        $contentRenderer = $this->createMock(PageDocumentContentRendererInterface::class);
        
        $page = new PageDocument($category1, 'Test Page', $slugGenerator, 'Test content', $contentRenderer);

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
