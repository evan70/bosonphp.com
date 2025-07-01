<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

/**
 * Representation of all value objects that contain {@see int} casting.
 *
 * @template-covariant T of int = int
 * @template-extends StringValueObjectInterface<numeric-string>
 */
interface IntValueObjectInterface extends StringValueObjectInterface
{
    /**
     * Gets VO value as PHP {@see int} scalar.
     *
     * @return T
     */
    public function toInteger(): int;
}
