<?php

declare(strict_types=1);

namespace App\Infrastructure\Content;

use App\Domain\Documentation\PageDocumentContent;
use App\Domain\Documentation\PageDocumentContentRendererInterface;
use League\CommonMark\ConverterInterface;

final readonly class PageDocumentContentRenderer implements PageDocumentContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $entity): string
    {
        assert($entity instanceof PageDocumentContent);

        return $this->converter->convert($entity->value)
            ->getContent();
    }
}
