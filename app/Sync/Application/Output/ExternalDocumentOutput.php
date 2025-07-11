<?php

declare(strict_types=1);

namespace App\Sync\Application\Output;

use App\Sync\Domain\ExternalDocument;

final readonly class ExternalDocumentOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $path,
        /**
         * @var non-empty-string
         */
        public string $hash,
        public string $content,
    ) {}

    public static function fromExternalDocument(ExternalDocument $document): self
    {
        return new self(
            path: $document->path,
            hash: $document->hash,
            content: $document->content,
        );
    }
}
