<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Menu;

use App\Domain\Documentation\Page;
use Local\Component\Set\RelationSet;

/**
 * @template-extends RelationSet<Menu, Page>
 */
final class MenuSet extends RelationSet
{
    protected function shouldAdd(mixed $entry): bool
    {
        if ($entry->menu !== $this->parent) {
            throw new \LogicException('Could not change menu relation');
        }

        return parent::shouldAdd($entry);
    }
}
