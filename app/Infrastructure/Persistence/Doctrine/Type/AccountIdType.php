<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\Account\AccountId;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Type
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
