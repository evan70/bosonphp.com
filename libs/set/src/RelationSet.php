<?php

declare(strict_types=1);

namespace Local\Component\Set;

use Doctrine\Common\Collections\Collection as CollectionInterface;

/**
 * @template TContext of object
 * @template TValue of mixed
 * @template-extends ReadableRelationSet<TContext, TValue>
 * @template-implements CollectionInterface<array-key, TValue>
 *
 * @phpstan-consistent-constructor
 */
class RelationSet extends ReadableRelationSet implements CollectionInterface
{
    /**
     * @param TValue $entry
     */
    protected function afterAdd(mixed $entry): void
    {
        // NOOP
    }

    /**
     * @param TValue $entry
     */
    protected function shouldAdd(mixed $entry): bool
    {
        return !$this->delegate->contains($entry);
    }

    public function add(mixed $element): void
    {
        if ($this->shouldAdd($element)) {
            $this->delegate->add($element);

            $this->afterAdd($element);
        }
    }

    public function clear(): void
    {
        $this->delegate->clear();
    }

    public function remove(int|string $key): mixed
    {
        return $this->delegate->remove($key);
    }

    public function removeElement(mixed $element): bool
    {
        return $this->delegate->removeElement($element);
    }

    public function set(int|string $key, mixed $value): void
    {
        if ($this->shouldAdd($value)) {
            $this->delegate->set($key, $value);
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->delegate->offsetExists($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->delegate->offsetGet($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->delegate->offsetSet($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->delegate->offsetUnset($offset);
    }
}
