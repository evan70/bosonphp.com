<?php

declare(strict_types=1);

namespace App\Search\Application\UseCase\GetDocumentationSearchResults;

use App\Search\Application\Output\SearchResultsListOutput;

final readonly class GetDocumentationSearchResultsOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $version,
        public string $query = '',
        public SearchResultsListOutput $results = new SearchResultsListOutput(),
    ) {}
}
