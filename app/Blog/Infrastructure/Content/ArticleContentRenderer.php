<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Content;

use App\Blog\Domain\ArticleContent;
use App\Blog\Domain\ArticleContentRendererInterface;
use League\CommonMark\ConverterInterface;

final readonly class ArticleContentRenderer implements ArticleContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $entity): string
    {
        assert($entity instanceof ArticleContent);

        return $this->converter->convert($entity->value)
            ->getContent();
    }
}
