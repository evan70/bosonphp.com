<?php

declare(strict_types=1);

namespace App\Shared\Application\Output;

/**
 * @template-covariant T of mixed
 *
 * @template-extends CollectionOutput<T>
 */
abstract readonly class CountableCollectionOutput extends CollectionOutput implements \Countable
{
    /**
     * @param iterable<mixed, T> $items
     */
    public function __construct(
        iterable $items,
        /**
         * @var int<0, max>
         */
        public int $itemsPerPage,
        /**
         * @var int<0, max>
         */
        public int $count,
    ) {
        parent::__construct($items);
    }

    /**
     * @return int<0, max>
     */
    public function getPages(): int
    {
        return (int) \ceil($this->count / $this->itemsPerPage);
    }

    /**
     * @return int<0, max>
     */
    public function count(): int
    {
        return $this->count;
    }
}
