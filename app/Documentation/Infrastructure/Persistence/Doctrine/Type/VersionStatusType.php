<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Type;

use App\Documentation\Domain\Version\Status;
use App\Infrastructure\Persistence\Doctrine\Type\StringEnumType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends StringEnumType<Status>
 */
final class VersionStatusType extends StringEnumType
{
    protected static function getEnumClass(): string
    {
        return Status::class;
    }
}
