<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Type;

use App\Documentation\Domain\PageId;
use App\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<PageId>
 */
final class PageIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return PageId::class;
    }
}
