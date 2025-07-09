<?php

declare(strict_types=1);

namespace App\Shared\Application\Output;

/**
 * @template T of mixed
 *
 * @template-extends CollectionOutput<T>
 */
abstract class CountableCollectionOutput extends CollectionOutput implements \Countable
{
    /**
     * @var int<0, max>
     */
    public int $pages {
        /** @phpstan-ignore-next-line PHPStan false-positive */
        get => (int) \ceil($this->count / $this->itemsPerPage);
    }

    /**
     * @param iterable<mixed, T> $items
     */
    public function __construct(
        iterable $items,
        /**
         * @var int<0, max>
         */
        public readonly int $itemsPerPage,
        /**
         * @var int<0, max>
         */
        public readonly int $count,
    ) {
        parent::__construct($items);
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->count;
    }
}
