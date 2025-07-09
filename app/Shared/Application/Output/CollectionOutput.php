<?php

declare(strict_types=1);

namespace App\Shared\Application\Output;

/**
 * @template T of mixed
 * @template-implements \IteratorAggregate<array-key, T>
 */
abstract class CollectionOutput implements \IteratorAggregate
{
    /**
     * @param iterable<mixed, T> $items
     */
    public function __construct(
        /**
         * @var iterable<mixed, T>
         */
        public iterable $items {
            /**
             * @return list<T>
             */
            get {
                if (\is_array($this->items) && \array_is_list($this->items)) {
                    return $this->items;
                }

                return $this->items = \iterator_to_array($this->items, false);
            }
            /**
             * @param iterable<mixed, T> $items
             */
            set(iterable $items) => $items;
        }
    ) {}

    public function getIterator(): \Traversable
    {
        /** @phpstan-ignore-next-line : PHPStan false-positive, $items is list<T> */
        return new \ArrayIterator($this->items);
    }
}
