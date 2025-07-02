<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Article\Category\CategoryId;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<CategoryId>
 */
final class CategoryIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return CategoryId::class;
    }
}
