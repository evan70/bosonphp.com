<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Version\Version;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Version, Page>
 */
final class PagesOfVersionCollection extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->version !== $this->parent) {
            throw new \LogicException('Could not change version relation');
        }

        return parent::shouldAdd($entry);
    }
}
