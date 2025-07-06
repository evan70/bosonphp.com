<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationCategoriesList;

use App\Application\Query\GetDocumentationVersionByNameQuery;
use App\Application\UseCase\GetDocumentationVersionByName\GetDocumentationVersionByNameResult;
use App\Domain\Shared\Bus\QueryBusInterface;

final readonly class GetDocumentationCategoriesListUseCase
{
    public function __construct(
        private QueryBusInterface $queries,
    ) {}

    public function getCategories(?string $version): GetDocumentationCategoriesListResult
    {
        /** @var GetDocumentationVersionByNameResult $result */
        $result = $this->queries->get(new GetDocumentationVersionByNameQuery($version));

        return new GetDocumentationCategoriesListResult(
            version: $result->version,
            categories: $result->version->categories,
        );
    }
}
