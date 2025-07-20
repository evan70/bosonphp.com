<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\Link;

final readonly class LinkOutput extends PageOutput
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

    public static function fromLink(Link $page): self
    {
        return new self(
            title: $page->title,
            uri: $page->uri,
        );
    }
}
