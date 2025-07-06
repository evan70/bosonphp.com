<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetArticlesList;

use App\Application\UseCase\GetArticlesList\Exception\CategoryNotFoundException;
use App\Application\UseCase\GetArticlesList\Exception\InvalidCategoryUriException;
use App\Application\UseCase\GetArticlesList\Exception\InvalidPageException;
use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\Repository\ArticleCategoryBySlugProviderInterface;
use App\Domain\Blog\Repository\ArticlePaginateProviderInterface;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class GetArticlesListUseCase
{
    public function __construct(
        private ArticlePaginateProviderInterface $articles,
        private ArticleCategoryBySlugProviderInterface $categories,
        private ValidatorInterface $validator,
    ) {}

    private function findCategoryByArgument(?string $categoryUri): ?ArticleCategory
    {
        if ($categoryUri === null) {
            return null;
        }

        $errors = $this->validator->validate($categoryUri, [
            new Regex('/^' . Requirement::ASCII_SLUG . '$/'),
        ]);

        if ($errors->count() > 0) {
            throw new InvalidCategoryUriException();
        }

        return $this->categories->findBySlug($categoryUri)
            ?? throw new CategoryNotFoundException();
    }

    /**
     * @return int<1, 2147483647>
     */
    private function getPageByArgument(int $page): int
    {
        $errors = $this->validator->validate($page, [
            new GreaterThanOrEqual(value: 1),
            new LessThanOrEqual(value: 2_147_483_647),
        ]);

        if ($errors->count() > 0) {
            throw new InvalidPageException();
        }

        return $page;
    }

    public function getArticles(int $page, ?string $categoryUri): GetArticlesListResult
    {
        $articles = $this->articles->getAllAsPaginator(
            page: $page = $this->getPageByArgument($page),
            category: $category = $this->findCategoryByArgument($categoryUri),
        );

        return new GetArticlesListResult(
            page: $page,
            articles: $articles,
            category: $category,
        );
    }
}
