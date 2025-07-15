<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

use App\Shared\Domain\Bus\EventId;

abstract readonly class PageDocumentEvent extends PageEvent
{
    /**
     * @param non-empty-string $version
     * @param non-empty-string $category
     * @param non-empty-string $title
     * @param non-empty-string $uri
     */
    public function __construct(
        string $version,
        string $category,
        string $title,
        string $uri,
        public string $content,
        EventId $id = new EventId(),
    ) {
        parent::__construct(
            version: $version,
            category: $category,
            title: $title,
            uri: $uri,
            id: $id,
        );
    }
}
