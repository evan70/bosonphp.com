<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryEvent;
use App\Documentation\Domain\Category\Service\CategoryInfo;
use App\Documentation\Domain\Version\Version;

abstract readonly class CategoriesComputer
{
    /**
     * @param array<non-empty-string, Category> $existing
     * @param array<non-empty-string, CategoryInfo> $updated
     *
     * @return iterable<Category, CategoryEvent>
     */
    abstract public function process(Version $version, array $existing, array $updated): iterable;
}
