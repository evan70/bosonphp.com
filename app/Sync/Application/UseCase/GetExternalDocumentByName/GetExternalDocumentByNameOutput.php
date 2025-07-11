<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GetExternalDocumentByName;

use App\Sync\Application\Output\ExternalDocumentOutput;

final readonly class GetExternalDocumentByNameOutput
{
    public function __construct(
        public ExternalDocumentOutput $document,
    ) {}
}
