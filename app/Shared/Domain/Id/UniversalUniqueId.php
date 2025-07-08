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
     * @param non-empty-string|\Stringable $value
     */
    final public function __construct(string|\Stringable $value)
    {
        $value = (string) $value;

        assert(\preg_match(self::PATTERN, $value) !== false);

        /** @var non-empty-string $value */
        $this->value = $value;
    }

    public static function new(?ClockInterface $clock = null): static
    {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        return new static(Uuid::uuid7($clock?->now()));
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
