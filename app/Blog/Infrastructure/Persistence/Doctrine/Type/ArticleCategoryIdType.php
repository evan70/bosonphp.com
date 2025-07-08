<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Type;

use App\Blog\Domain\Category\CategoryId;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<CategoryId>
 */
final class ArticleCategoryIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return CategoryId::class;
    }
}
