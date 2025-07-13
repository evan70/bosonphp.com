<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionsList;

use App\Shared\Domain\Bus\QueryId;

final readonly class GetVersionsListQuery
{
    public function __construct(
        public QueryId $id = new QueryId(),
    ) {}
}
