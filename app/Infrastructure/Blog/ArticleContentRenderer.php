<?php

declare(strict_types=1);

namespace App\Infrastructure\Blog;

use App\Domain\Blog\ArticleContentRendererInterface;
use App\Domain\Blog\Content;
use League\CommonMark\ConverterInterface;

final readonly class ArticleContentRenderer implements ArticleContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $entity): string
    {
        assert($entity instanceof Content);

        return $this->converter->convert($entity->value)
            ->getContent();
    }
}
