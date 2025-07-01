<?php

declare(strict_types=1);

namespace App\Domain\Account\Integration;

use App\Domain\Account\Account;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Account, Integration>
 */
final class IntegrationsSet extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->account !== $this->parent) {
            throw new \LogicException('Could not change integration relation');
        }

        return parent::shouldAdd($entry);
    }
}
