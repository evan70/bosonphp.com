<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

/**
 * Represents 64-bit (16-chars hexadecimal string) binary hash ID
 *
 * @phpstan-consistent-constructor
 */
abstract readonly class Hash64Id implements IdInterface
{
    /**
     * Contains 16-bytes length hexadecimal string
     *
     * @var non-empty-string
     */
    private string $value;

    /**
     * @param non-empty-string|\Stringable $value
     */
    final public function __construct(string|\Stringable $value)
    {
        $string = (string) $value;

        assert(\strlen($string) === 16, 'Expects 16-chars length string');
        assert(\ctype_xdigit($string), 'Expects hexadecimal string');

        $this->value = $string;
    }

    /**
     * @api
     */
    public static function createFrom(self $id): static
    {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        return new static($id->value);
    }

    /**
     * @api
     */
    public static function createFromString(string $value): static
    {
        $hash = \hash('xxh3', $value);

        assert(\is_string($hash), 'Failed to create hash');

        /** @phpstan-ignore-next-line : PHPStan false-positive */
        return new static($hash);
    }

    /**
     * @api
     *
     * @return non-empty-string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @api
     *
     * @return non-empty-string
     */
    public function toBinaryString(): string
    {
        /** @var non-empty-string */
        return (string) \hex2bin($this->value);
    }

    public function equals(mixed $object): bool
    {
        return $this === $object
            || ($object instanceof static && $this->value === $object->value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
