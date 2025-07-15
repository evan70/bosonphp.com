<?php

declare(strict_types=1);

namespace App\Blog\Domain\Content;

/**
 * Defines contract for content renderers in the {@see ArticleContent} VO.
 */
interface ArticleContentRendererInterface
{
    public function renderContent(ArticleContent $content): string;
}
