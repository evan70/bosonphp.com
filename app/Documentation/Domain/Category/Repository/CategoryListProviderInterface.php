<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Repository;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Version;

interface CategoryListProviderInterface
{
    /**
     * @return iterable<array-key, Category>
     */
    public function getAll(Version $version): iterable;
}
