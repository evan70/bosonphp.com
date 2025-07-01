<?php

declare(strict_types=1);

namespace App\Domain\Article\Content;

/**
 * Defines contract for content renderers in the {@see Content} VO.
 */
interface RendererInterface
{
    /**
     * Renders the provided article content string.
     *
     * @return ($content is non-empty-string ? non-empty-string : string)
     *
     * @throws \Throwable in case of rendering error occurs
     */
    public function render(string $content): string;
}
