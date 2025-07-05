<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type\Documentation;

use App\Domain\Documentation\Version\VersionId;
use App\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
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
