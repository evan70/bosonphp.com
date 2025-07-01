<?php

declare(strict_types=1);

namespace App\Domain\Article\Content;

use App\Domain\Shared\ValueObject\StringValueObjectInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Value object representing the content of an {@see Article}.
 */
#[ORM\Embeddable]
final class Content implements StringValueObjectInterface
{
    /**
     * Rendered content string value.
     */
    #[ORM\Column(type: 'text', options: ['default' => ''])]
    public private(set) string $rendered;

    /**
     * Raw content string value.
     */
    #[ORM\Column(name: 'raw', type: 'text', options: ['default' => ''])]
    public string $value {
        get => $this->value;
        set (string|\Stringable $value) {
            $this->value = (string) $value;
            $this->rendered = $this->renderer->render($this->value);
        }
    }

    public function __construct(
        string|\Stringable $value,
        private readonly RendererInterface $renderer,
    ) {
        $this->value = $value;
    }

    public static function empty(RendererInterface $renderer): self
    {
        return new self('', $renderer);
    }

    public function toString(): string
    {
        return $this->rendered ?? $this->value;
    }

    public function equals(mixed $object): bool
    {
        return $this === $object
            || ($object instanceof self && $this->value === $object->value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
