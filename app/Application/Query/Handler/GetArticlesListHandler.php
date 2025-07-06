<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetArticlesListQuery;
use App\Application\UseCase\GetArticlesList\GetArticlesListResult;
use App\Application\UseCase\GetArticlesList\GetArticlesListUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticlesListHandler
{
    public function __construct(
        private GetArticlesListUseCase $workflow,
    ) {}

    public function __invoke(GetArticlesListQuery $query): GetArticlesListResult
    {
        return $this->workflow->getArticles(
            page: $query->page,
            categoryUri: $query->categoryUri,
        );
    }
}
