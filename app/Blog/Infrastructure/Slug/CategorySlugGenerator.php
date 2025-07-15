<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Slug;

use App\Blog\Domain\Category\Category;
use App\Blog\Domain\Category\CategorySlugGeneratorInterface;
use App\Shared\Infrastructure\Slug\SlugGenerator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Slug
 *
 * @template-extends SlugGenerator<Category>
 */
final readonly class CategorySlugGenerator extends SlugGenerator implements
    CategorySlugGeneratorInterface
{
    public function createSlug(object $entity): string
    {
        assert($entity instanceof Category);

        return $this->createSlugByString($entity->title);
    }
}
