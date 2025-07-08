<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use App\Shared\Infrastructure\Content\SlugGenerator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Content
 *
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
