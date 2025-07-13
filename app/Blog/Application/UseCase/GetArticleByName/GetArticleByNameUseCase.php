<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Blog\Application\Output\Article\FullArticleOutput;
use App\Blog\Application\Output\Category\CategoryOutput;
use App\Blog\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Blog\Domain\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticleByNameUseCase
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
    ) {}

    public function __invoke(GetArticleByNameQuery $query): GetArticleByNameOutput
    {
        /** @var non-empty-string $uri : Validated by constraint */
        $uri = $query->uri;

        $article = $this->articles->findByUri($uri);

        if ($article === null) {
            throw new ArticleNotFoundException();
        }

        return new GetArticleByNameOutput(
            uri: $uri,
            category: CategoryOutput::fromCategory($article->category),
            article: FullArticleOutput::fromArticle($article),
        );
    }
}
