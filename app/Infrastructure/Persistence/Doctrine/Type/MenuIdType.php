<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Documentation\Menu\MenuId;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<MenuId>
 */
final class MenuIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return MenuId::class;
    }
}
