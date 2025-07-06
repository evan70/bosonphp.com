<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetDocumentationCategoriesListQuery;
use App\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetDocumentationCategoriesListHandler
{
    public function __construct(
        private GetDocumentationCategoriesListUseCase $workflow,
    ) {}

    public function __invoke(GetDocumentationCategoriesListQuery $query): GetDocumentationCategoriesListResult
    {
        return $this->workflow->getCategories(
            version: $query->version,
        );
    }
}
