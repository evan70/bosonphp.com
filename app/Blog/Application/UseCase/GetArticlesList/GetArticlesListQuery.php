<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

final readonly class GetArticlesListQuery
{
    public function __construct(
        #[GreaterThanOrEqual(value: 1)]
        #[LessThanOrEqual(value: 2_147_483_647)]
        public int $page,
        #[NotBlank]
        #[Regex('/^' . Requirement::ASCII_SLUG . '$/')]
        public ?string $uri = null,
        public QueryId $id = new QueryId(),
    ) {}
}
