<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticleByName;

use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameQuery;
use App\Blog\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Blog\Application\UseCase\GetArticleByName\Exception\InvalidArticleUriException;
use App\Blog\Domain\ArticleRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler(bus: 'query.bus', method: 'getArticle')]
final readonly class GetArticleByNameUseCase
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
        private ValidatorInterface $validator,
    ) {}

    public function getArticle(GetArticleByNameQuery $query): GetArticleByNameResult
    {
        $name = $query->articleUri;

        $errors = $this->validator->validate($name, [
            new Regex('/^' . Requirement::ASCII_SLUG . '$/'),
        ]);

        if ($errors->count() > 0) {
            throw new InvalidArticleUriException();
        }

        /** @var non-empty-string $name */
        $article = $this->articles->findBySlug($name);

        if ($article === null) {
            throw new ArticleNotFoundException();
        }

        return new GetArticleByNameResult(
            article: $article,
        );
    }
}
