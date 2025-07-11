<?php

declare(strict_types=1);

namespace App\Sync\Domain;

final readonly class ExternalDocument extends ExternalDocumentReference
{
    /**
     * @param non-empty-string $path
     * @param non-empty-string $hash
     */
    public function __construct(
        string $path,
        string $hash,
        public string $content,
    ) {
        parent::__construct($path, $hash);
    }
}
