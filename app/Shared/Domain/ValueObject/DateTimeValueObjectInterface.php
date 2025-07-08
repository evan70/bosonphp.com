<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface DateTimeValueObjectInterface extends ValueObjectInterface
{
    /**
     * Gets VO date-time value as PHP {@see int} scalar.
     */
    public function toTimestamp(): int;

    /**
     * Gets VO date-time value as PHP {@see \DateTimeImmutable} object.
     */
    public function toDateTime(): \DateTimeImmutable;
}
