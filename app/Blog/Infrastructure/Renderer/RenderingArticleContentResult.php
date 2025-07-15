<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Renderer;

use App\Shared\Domain\Renderer\RenderingResultInterface;

final readonly class RenderingArticleContentResult implements RenderingResultInterface
{
    public function __construct(
        private string $content,
    ) {}

    public function __toString(): string
    {
        return $this->content;
    }
}
