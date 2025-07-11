<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GetExternalDocumentByName;

final readonly class GetExternalDocumentByNameQuery
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        /**
         * @var non-empty-string
         */
        public string $path,
    ) {}
}
