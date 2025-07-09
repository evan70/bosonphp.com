<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

/**
 * Representation of all value objects that contain {@see string} casting.
 *
 * @template-covariant T of string = string
 * @template-extends StringValueObjectInterface<T>
 */
interface BinaryStringValueObjectInterface extends StringValueObjectInterface
{
    /**
     * Gets VO value as PHP binary {@see string} scalar.
     *
     * @return T
     */
    public function toBytes(): string;
}
