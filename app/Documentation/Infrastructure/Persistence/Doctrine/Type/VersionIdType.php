<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Type;

use App\Documentation\Domain\Version\VersionId;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<VersionId>
 */
final class VersionIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return VersionId::class;
    }
}
