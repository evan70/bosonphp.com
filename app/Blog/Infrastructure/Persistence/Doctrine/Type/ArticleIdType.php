<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Type;

use App\Blog\Domain\ArticleId;
use App\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<ArticleId>
 */
final class ArticleIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return ArticleId::class;
    }
}
