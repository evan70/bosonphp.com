<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\PageDocument;

final readonly class PageDocumentOutput extends PageOutput
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        string $title,
        string $uri,
        public string $content,
    ) {
        parent::__construct(
            title: $title,
            uri: $uri,
            type: PageTypeOutput::Document,
        );
    }

    public static function fromPageDocument(PageDocument $page): self
    {
        return new self(
            title: $page->title,
            uri: $page->uri,
            content: $page->content->rendered,
        );
    }
}
