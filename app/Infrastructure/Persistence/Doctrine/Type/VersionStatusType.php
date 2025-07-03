<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Documentation\Version\Status;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
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
