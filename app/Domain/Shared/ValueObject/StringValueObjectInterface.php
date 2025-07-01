<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

/**
 * Representation of all value objects that contain {@see string} casting.
 *
 * @template-covariant T of string = string
 */
interface StringValueObjectInterface extends ValueObjectInterface
{
    /**
     * Gets VO value as PHP {@see string} scalar.
     *
     * @return T
     */
    public function toString(): string;
}
