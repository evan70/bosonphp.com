<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Shared\Domain\Bus\QueryId;

final readonly class GetArticlesListQuery
{
    public function __construct(
        public int $page,
        public ?string $uri = null,
        public QueryId $id = new QueryId(),
    ) {}
}
