<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetArticleBySlugQuery;
use App\Application\UseCase\GetArticleByName\GetArticleByNameResult;
use App\Application\UseCase\GetArticleByName\GetArticleByNameUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticleBySlugHandler
{
    public function __construct(
        private GetArticleByNameUseCase $workflow,
    ) {}

    public function __invoke(GetArticleBySlugQuery $query): GetArticleByNameResult
    {
        return $this->workflow->getArticle(
            name: $query->articleUri,
        );
    }
}
