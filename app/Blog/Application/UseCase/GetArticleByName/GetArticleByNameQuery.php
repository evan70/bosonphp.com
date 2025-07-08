<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

final readonly class GetArticleByNameQuery
{
    public function __construct(
        public string $articleUri,
    ) {}
}
