<?php

declare(strict_types=1);

namespace App\Domain\Account\Integration;

use App\Domain\Shared\ValueObject\StringValueObjectInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @template-implements StringValueObjectInterface<non-empty-string>
 */
#[ORM\Embeddable]
final readonly class ConnectionInfo implements StringValueObjectInterface
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        #[ORM\Column(name: 'dsn')]
        public string $value,
    ) {}

    public function equals(mixed $object): bool
    {
        return $this === $object
            || ($object instanceof self && $this->value === $object->value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
