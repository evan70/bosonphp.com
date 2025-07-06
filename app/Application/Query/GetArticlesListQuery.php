<?php

declare(strict_types=1);

namespace App\Application\Query;

final readonly class GetArticlesListQuery
{
    public function __construct(
        public int $page,
        public ?string $categoryUri = null,
    ) {}
}
