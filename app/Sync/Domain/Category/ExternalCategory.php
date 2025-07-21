<?php

declare(strict_types=1);

namespace App\Sync\Domain\Category;

use App\Shared\Domain\AggregateRootInterface;
use App\Sync\Domain\ExternalPage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\ReadableCollection;

final readonly class ExternalCategory implements AggregateRootInterface
{
    /**
     * @var ReadableCollection<array-key, ExternalPage>
     */
    public ReadableCollection $pages;

    public function __construct(
        public ExternalCategoryId $id,
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
