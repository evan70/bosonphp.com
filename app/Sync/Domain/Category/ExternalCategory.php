<?php

declare(strict_types=1);

namespace App\Sync\Domain\Category;

use App\Sync\Domain\ExternalDocument;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ReadableCollection;

final readonly class ExternalCategory
{
    /**
     * @var ReadableCollection<array-key, ExternalDocument>
     */
    public ReadableCollection $pages;

    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $name,
        /**
         * @var non-empty-string|null
         */
        public ?string $description = null,
        /**
         * @var non-empty-string|null
         */
        public ?string $icon = null,
    ) {
        $this->pages = new ArrayCollection();
    }
}
