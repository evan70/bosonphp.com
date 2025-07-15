<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Slug;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use App\Shared\Infrastructure\Slug\SlugGenerator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Slug
 *
 * @template-extends SlugGenerator<Article>
 */
final readonly class ArticleByTitleSlugGenerator extends SlugGenerator implements
    ArticleSlugGeneratorInterface
{
    public function generateSlug(object $entity): string
    {
        assert($entity instanceof Article);

        return $this->createSlugByString($entity->title);
    }
}
