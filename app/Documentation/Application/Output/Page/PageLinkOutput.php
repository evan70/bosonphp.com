<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\PageLink;

final readonly class PageLinkOutput extends PageOutput
{
    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        string $title,
        string $uri,
    ) {
        parent::__construct(
            title: $title,
            uri: $uri,
            type: PageTypeOutput::Link,
        );
    }

    public static function fromPageLink(PageLink $page): self
    {
        return new self(
            title: $page->title,
            uri: $page->uri,
        );
    }
}
