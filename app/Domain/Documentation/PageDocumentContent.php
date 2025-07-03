<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Shared\ValueObject\StringValueObjectInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Value object representing the content of a {@see PageDocument}.
 */
#[ORM\Embeddable]
final class PageDocumentContent implements StringValueObjectInterface
{
    /**
     * Rendered content string value.
     */
    #[ORM\Column(name: 'rendered', type: 'text', options: ['default' => ''])]
    public private(set) string $rendered;

    /**
     * Raw content string value.
     */
    #[ORM\Column(name: 'raw', type: 'text', options: ['default' => ''])]
    public string $value {
        get => $this->value;
        set(string|\Stringable $value) {
            $this->value = (string) $value;
            $this->rendered = $this->contentRenderer->renderContent($this);
        }
    }

    public function __construct(
        string|\Stringable $value,
        private readonly PageDocumentContentRendererInterface $contentRenderer,
    ) {
        $this->value = $value;
    }

    public static function empty(PageDocumentContentRendererInterface $contentRenderer): self
    {
        return new self('', $contentRenderer);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function equals(mixed $object): bool
    {
        return $this === $object
            || ($object instanceof self && $this->value === $object->value);
    }

    public function __toString(): string
    {
        return $this->rendered;
    }
}
