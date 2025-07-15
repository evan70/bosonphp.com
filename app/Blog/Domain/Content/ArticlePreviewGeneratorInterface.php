<?php

declare(strict_types=1);

namespace App\Blog\Domain\Content;

interface ArticlePreviewGeneratorInterface
{
    public function generatePreview(ArticleContent $content): string;
}
