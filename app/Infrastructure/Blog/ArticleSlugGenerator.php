<?php

declare(strict_types=1);

namespace App\Infrastructure\Blog;

use App\Domain\Blog\Article;
use App\Domain\Blog\ArticleSlugGeneratorInterface;

/**
 * @template-extends SlugGenerator<Article>
 */
final readonly class ArticleSlugGenerator extends SlugGenerator implements
    ArticleSlugGeneratorInterface
{
    public function createSlug(object $entity): string
    {
        assert($entity instanceof Article);

        return $this->createSlugByString($entity->title);
    }
}
