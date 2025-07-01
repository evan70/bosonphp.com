<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Article\Category\Category;
use App\Domain\Article\Category\CategorySlugGeneratorInterface;

/**
 * @template-extends SlugGenerator<Category>
 */
final readonly class ArticleCategorySlugGenerator extends SlugGenerator implements
    CategorySlugGeneratorInterface
{
    public function createSlug(object $entity): string
    {
        assert($entity instanceof Category);

        return $this->createSlugByString($entity->title);
    }
}
