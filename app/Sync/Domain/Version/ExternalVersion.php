<?php

declare(strict_types=1);

namespace App\Sync\Domain\Version;

use App\Sync\Domain\Category\ExternalCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ReadableCollection;

final readonly class ExternalVersion
{
    /**
     * @var ReadableCollection<array-key, ExternalCategory>
     */
    public ReadableCollection $categories;

    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $name,
    ) {
        $this->categories = new ArrayCollection();
    }
}
