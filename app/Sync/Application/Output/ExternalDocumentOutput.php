<?php

declare(strict_types=1);

namespace App\Sync\Application\Output;

use App\Sync\Domain\ExternalDocument;

final readonly class ExternalDocumentOutput
{
    public function __construct(
        /**
         * @var non-empty-lowercase-string
         */
        public string $hash,
        /**
         * @var non-empty-string
         */
        public string $path,
        public string $content,
    ) {}

    public static function fromExternalDocument(ExternalDocument $document): self
    {
        return new self(
            hash: $document->hash,
            path: $document->path,
            content: (string) $document->content,
        );
    }
}
