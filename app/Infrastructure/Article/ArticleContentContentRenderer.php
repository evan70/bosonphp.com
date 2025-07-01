<?php

declare(strict_types=1);

namespace App\Infrastructure\Article;

use App\Domain\Article\ArticleContentRendererInterface;
use App\Domain\Article\Content;
use League\CommonMark\ConverterInterface;

final readonly class ArticleContentContentRenderer implements ArticleContentRendererInterface
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
