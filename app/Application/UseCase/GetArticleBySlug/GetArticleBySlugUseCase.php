<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticleBySlug;

use App\Application\UseCase\GetArticleBySlug\Exception\ArticleNotFoundException;
use App\Application\UseCase\GetArticleBySlug\Exception\InvalidArticleUriException;
use App\Domain\Blog\ArticleRepositoryInterface;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class GetArticleBySlugUseCase
{
    public function __construct(
        private ArticleRepositoryInterface $articles,
        private ValidatorInterface $validator,
    ) {}

    public function getArticle(string $name): GetArticleBySlugResult
    {
        $errors = $this->validator->validate($name, [
            new Regex('/^' . Requirement::ASCII_SLUG . '$/'),
        ]);

        if ($errors->count() > 0) {
            throw new InvalidArticleUriException();
        }

        $article = $this->articles->findBySlug($name);

        if ($article === null) {
            throw new ArticleNotFoundException();
        }

        return new GetArticleBySlugResult(
            article: $article,
        );
    }
}
