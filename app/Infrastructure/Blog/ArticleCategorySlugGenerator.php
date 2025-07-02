<?php

declare(strict_types=1);

namespace App\Infrastructure\Blog;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategorySlugGeneratorInterface;

/**
 * @template-extends SlugGenerator<ArticleCategory>
 */
final readonly class ArticleCategorySlugGenerator extends SlugGenerator implements
    ArticleCategorySlugGeneratorInterface
{
    public function createSlug(object $entity): string
    {
        assert($entity instanceof ArticleCategory);

        return $this->createSlugByString($entity->title);
    }
}
