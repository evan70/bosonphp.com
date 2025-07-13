<?php

declare(strict_types=1);

namespace App\Shared\Domain\Id;

use Psr\Clock\ClockInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @phpstan-consistent-constructor
 */
abstract readonly class UniversalUniqueId implements IdInterface
{
    /**
     * @var non-empty-string
     */
    private const string PATTERN = UniversalUniqueIdFactory::PATTERN;

    /**
     * @var non-empty-string
     */
    private string $value;

    /**
     * @param non-empty-string|\Stringable|null $value
     */
    final public function __construct(string|\Stringable|null $value = null)
    {
        $value = (string) ($value ?? self::createRawUuid7());

        assert(\preg_match(self::PATTERN, $value) !== false);

        /** @var non-empty-string $value */
        $this->value = $value;
    }

    private static function createRawUuid7(?ClockInterface $clock = null): UuidInterface
    {
        return Uuid::uuid7($clock?->now());
    }

    public static function new(?ClockInterface $clock = null): static
    {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        return new static(self::createRawUuid7($clock));
    }

    public static function createFrom(self $uuid): static
    {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        return new static($uuid->value);
    }

    /**
     * @api
     */
    public function toUuid(): UuidInterface
    {
        return Uuid::fromString($this->value);
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
