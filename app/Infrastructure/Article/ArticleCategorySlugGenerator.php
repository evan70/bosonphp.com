<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Article\Category\ArticleCategory;
use App\Domain\Article\Category\ArticleCategorySlugGeneratorInterface;

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
