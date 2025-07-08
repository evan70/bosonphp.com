<?php

declare(strict_types=1);

namespace App\Blog\Application\Query\Handler;

use App\Blog\Application\Query\GetArticleByNameQuery;
use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameResult;
use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticleBySlugHandler
{
    public function __construct(
        private GetArticleByNameUseCase $workflow,
    ) {}

    public function __invoke(GetArticleByNameQuery $query): GetArticleByNameResult
    {
        return $this->workflow->getArticle(
            name: $query->articleUri,
        );
    }
}
