<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

use App\Shared\Domain\Bus\QueryId;

final readonly class GetVersionByNameQuery
{
    public function __construct(
        public ?string $version = null,
        public QueryId $id = new QueryId(),
    ) {}
}
