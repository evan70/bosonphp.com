<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleSlugGeneratorInterface;

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
