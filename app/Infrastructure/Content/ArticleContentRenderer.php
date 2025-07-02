<?php

declare(strict_types=1);

namespace App\Infrastructure\Content;

use App\Domain\Blog\ArticleContentRendererInterface;
use App\Domain\Blog\ArticleContent;
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
