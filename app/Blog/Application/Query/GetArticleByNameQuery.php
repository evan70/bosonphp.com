<?php

declare(strict_types=1);

namespace App\Blog\Application\Query;

final readonly class GetArticleByNameQuery
{
    public function __construct(
        public string $articleUri,
    ) {}
}
