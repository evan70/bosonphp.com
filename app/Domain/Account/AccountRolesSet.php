<?php

declare(strict_types=1);

namespace App\Domain\Account;

use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Account, non-empty-string>
 */
final class AccountRolesSet extends RelationSet implements \Stringable
{
    public function __toString(): string
    {
        return \implode(', ', $this->toArray());
    }
}
