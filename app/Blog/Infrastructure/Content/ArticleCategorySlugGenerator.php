<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content;

use App\Blog\Domain\Category\ArticleCategory;
use App\Blog\Domain\Category\ArticleCategorySlugGeneratorInterface;
use App\Infrastructure\Content\SlugGenerator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Content
 *
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
