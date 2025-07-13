<?php

declare(strict_types=1);

namespace App\Sync\Application\UseCase\GetExternalDocumentByName;

use App\Shared\Domain\Bus\QueryId;

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
        public QueryId $id = new QueryId(),
    ) {}
}
