<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Renderer;

use App\Shared\Domain\Renderer\RenderingResultInterface;

final readonly class RenderingPageDocumentContentResult implements RenderingResultInterface
{
    public function __construct(
        private string $content,
    ) {}

    public function __toString(): string
    {
        return $this->content;
    }
}
