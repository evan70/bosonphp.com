<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Type;

use App\Documentation\Domain\PageType;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\StringEnumType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends StringEnumType<PageType>
 */
final class PageTypeType extends StringEnumType
{
    protected static function getEnumClass(): string
    {
        return PageType::class;
    }
}
