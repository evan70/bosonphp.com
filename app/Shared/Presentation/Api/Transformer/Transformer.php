<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Api\Transformer;

/**
 * @template TInput of mixed = mixed
 * @template-covariant TOutput of mixed = mixed
 * @template-implements TransformerInterface<TInput, TOutput>
 */
abstract readonly class Transformer implements TransformerInterface
{
    /**
     * @api
     *
     * @param iterable<mixed, TInput> $entries
     *
     * @return list<TOutput>
     */
    public function map(iterable $entries, mixed ...$args): array
    {
        $result = [];

        foreach ($entries as $entry) {
            $result[] = $this->transform($entry, ...$args);
        }

        return $result;
    }

    /**
     * @api
     *
     * @template TArgKey of array-key
     *
     * @param iterable<TArgKey, TInput> $entries
     *
     * @return array<TArgKey, TOutput>
     */
    public function mapWithKeys(iterable $entries, mixed ...$args): array
    {
        $result = [];

        foreach ($entries as $id => $entry) {
            $result[$id] = $this->transform($entry, ...$args);
        }

        return $result;
    }

    /**
     * @api
     *
     * @param iterable<mixed, TInput> $entries
     *
     * @return iterable<array-key, TOutput>
     */
    public function lazyMap(iterable $entries, mixed ...$args): iterable
    {
        foreach ($entries as $entry) {
            yield $this->transform($entry, ...$args);
        }
    }

    /**
     * @api
     *
     * @template TArgKey of array-key
     *
     * @param iterable<TArgKey, TInput> $entries
     *
     * @return iterable<TArgKey, TOutput>
     */
    public function lazyMapWithKeys(iterable $entries, mixed ...$args): iterable
    {
        foreach ($entries as $i => $entry) {
            yield $i => $this->transform($entry, ...$args);
        }
    }

    /**
     * @api
     *
     * @param TInput|null $entry
     *
     * @return TOutput|null
     */
    public function optional(mixed $entry, mixed ...$args): mixed
    {
        if ($entry === null) {
            return $entry;
        }

        return $this->transform($entry, ...$args);
    }
}
