<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\GetArticleBySlugQuery;
use App\Application\UseCase\GetArticleBySlug\GetArticleBySlugResult;
use App\Application\UseCase\GetArticleBySlug\GetArticleBySlugUseCase;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticleBySlugHandler
{
    public function __construct(
        private GetArticleBySlugUseCase $case,
    ) {}

    public function __invoke(GetArticleBySlugQuery $query): GetArticleBySlugResult
    {
        return $this->case->getArticle($query->slug);
    }
}
