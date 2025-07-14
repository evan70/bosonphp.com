<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Query object for retrieving a blog article by its URI.
 */
final readonly class GetArticleByNameQuery
{
    public function __construct(
        /**
         * The unique URI slug of the article to retrieve.
         */
        #[NotBlank(allowNull: false)]
        #[Regex('/^' . Requirement::ASCII_SLUG . '$/')]
        public string $uri,
        public QueryId $id = new QueryId(),
    ) {}
}
