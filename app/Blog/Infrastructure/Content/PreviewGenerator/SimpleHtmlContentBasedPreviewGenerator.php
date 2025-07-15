<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content\PreviewGenerator;

use App\Blog\Domain\Content\ArticleContent;
use App\Blog\Domain\Content\ArticlePreviewGeneratorInterface;
use Symfony\Component\String\TruncateMode;
use Symfony\Component\String\UnicodeString;

final readonly class SimpleHtmlContentBasedPreviewGenerator implements ArticlePreviewGeneratorInterface
{
    public function generatePreview(ArticleContent $content): string
    {
        return new UnicodeString(\strip_tags($content->rendered))
            ->truncate(200, cut: TruncateMode::WordAfter)
            ->toString();
    }
}
