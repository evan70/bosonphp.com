<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetCategoriesList;

use App\Shared\Domain\Bus\QueryId;

final readonly class GetCategoriesListQuery
{
    public function __construct(
        public QueryId $id = new QueryId(),
    ) {}
}
