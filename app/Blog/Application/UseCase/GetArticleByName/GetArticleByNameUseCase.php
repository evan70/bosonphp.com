<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Blog\Application\Output\Article\FullArticleOutput;
use App\Blog\Application\Output\Category\CategoryOutput;
use App\Blog\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Blog\Application\UseCase\GetArticleByName\Exception\InvalidArticleUriException;
use App\Blog\Domain\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticleByNameUseCase
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
        private ValidatorInterface $validator,
    ) {}

    /**
     * @return non-empty-string
     */
    private function getValidUri(GetArticleByNameQuery $query): string
    {
        $uri = $query->uri;

        $errors = $this->validator->validate($uri, [
            new Regex('/^' . Requirement::ASCII_SLUG . '$/'),
        ]);

        if ($errors->count() > 0) {
            throw new InvalidArticleUriException();
        }

        /** @var non-empty-string */
        return $uri;
    }

    public function __invoke(GetArticleByNameQuery $query): GetArticleByNameOutput
    {
        $uri = $this->getValidUri($query);

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
