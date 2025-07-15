<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Renderer;

use App\Documentation\Domain\PageDocumentContent;
use App\Documentation\Domain\PageDocumentContentRendererInterface;
use League\CommonMark\ConverterInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Renderer
 */
final readonly class PageDocumentContentRenderer implements PageDocumentContentRendererInterface
{
    public function __construct(
        private ConverterInterface $converter,
    ) {}

    public function renderContent(object $entity): RenderingPageDocumentContentResult
    {
        assert($entity instanceof PageDocumentContent);

        return new RenderingPageDocumentContentResult(
            content: $this->converter->convert($entity->value)
                ->getContent(),
        );
    }
}
