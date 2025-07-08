<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use App\Infrastructure\Content\SlugGenerator;

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
