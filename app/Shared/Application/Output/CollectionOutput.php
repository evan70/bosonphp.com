<?php

namespace App\Shared\Application\Output;

/**
 * @template-covariant T of mixed
 *
 * @template-implements \IteratorAggregate<array-key, T>
 */
abstract readonly class CollectionOutput implements \IteratorAggregate
{
    /**
     * @var list<T>
     */
    public array $items;

    /**
     * @param iterable<mixed, T> $items
     */
    public function __construct(
        iterable $items,
    ) {
        $this->items = \iterator_to_array($items, false);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}
