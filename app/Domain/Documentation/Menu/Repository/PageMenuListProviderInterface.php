<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Menu\Repository;

use App\Domain\Documentation\Menu\PageMenu;
use App\Domain\Documentation\Version\Version;

interface PageMenuListProviderInterface
{
    /**
     * @return iterable<array-key, PageMenu>
     */
    public function getAll(Version $version): iterable;
}
