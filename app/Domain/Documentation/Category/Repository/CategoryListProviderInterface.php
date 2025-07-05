<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Category\Repository;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\Version\Version;

interface CategoryListProviderInterface
{
    /**
     * @return iterable<array-key, Category>
     */
    public function getAll(Version $version): iterable;
}
