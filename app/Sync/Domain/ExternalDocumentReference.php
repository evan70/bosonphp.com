<?php

declare(strict_types=1);

namespace App\Sync\Domain;

readonly class ExternalDocumentReference
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
    ) {}
}
