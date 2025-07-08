<?php

declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence\Doctrine\Type;

use App\Account\Domain\AccountId;
use App\Shared\Infrastructure\Persistence\Doctrine\Type\UniversalUniqueIdType;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Account\Infrastructure\Persistence\Doctrine\Type
 *
 * @template-extends UniversalUniqueIdType<AccountId>
 */
final class AccountIdType extends UniversalUniqueIdType
{
    protected static function getClass(): string
    {
        return AccountId::class;
    }
}
