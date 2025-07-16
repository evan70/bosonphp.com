<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Content\ContentRenderer;

use App\Documentation\Domain\Content\PageDocumentContent;
use App\Documentation\Domain\Content\PageDocumentContentRendererInterface;
use League\CommonMark\ConverterInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Content\ContentRenderer
 */
final readonly class MarkdownPageDocumentContentRenderer implements
    PageDocumentContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $target): string
    {
        assert($target instanceof PageDocumentContent);

        $result = $this->converter->convert($target->value);

        $document = $result->getDocument();

        return $result->getContent();
    }
}
