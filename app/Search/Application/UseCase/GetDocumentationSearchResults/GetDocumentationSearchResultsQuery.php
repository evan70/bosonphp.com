<?php

declare(strict_types=1);

namespace App\Search\Application\UseCase\GetDocumentationSearchResults;

use App\Shared\Domain\Bus\QueryId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class GetDocumentationSearchResultsQuery
{
    public function __construct(
        public string $query,
        #[NotBlank(allowNull: true)]
        public ?string $version = null,
        public QueryId $id = new QueryId(),
    ) {}
}
