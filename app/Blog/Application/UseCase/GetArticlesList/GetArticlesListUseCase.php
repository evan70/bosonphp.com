<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Blog\Application\Output\Article\ShortArticlesListOutput;
use App\Blog\Application\Output\Category\CategoryOutput;
use App\Blog\Application\UseCase\GetArticlesList\Exception\CategoryNotFoundException;
use App\Blog\Application\UseCase\GetArticlesList\Exception\InvalidCategoryUriException;
use App\Blog\Application\UseCase\GetArticlesList\Exception\InvalidPageException;
use App\Blog\Domain\Category\Category;
use App\Blog\Domain\Category\Repository\CategoryByUriProviderInterface;
use App\Blog\Domain\Repository\ArticlesListPaginateProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticlesListUseCase
{
    public function __construct(
        private ArticlesListPaginateProviderInterface $articles,
        private CategoryByUriProviderInterface $categories,
        private ValidatorInterface $validator,
        /**
         * @var int<0, max>
         */
        private int $itemsPerPage = ArticlesListPaginateProviderInterface::DEFAULT_ITEMS_PER_PAGE,
    ) {}

    private function findCategoryByArgument(?string $categoryUri): ?Category
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

        /** @var non-empty-string $categoryUri */
        return $this->categories->findByUri($categoryUri)
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

        /** @var int<1, 2147483647> */
        return $page;
    }

    public function __invoke(GetArticlesListQuery $query): GetArticlesListOutput
    {
        $page = $query->page;
        $categoryUri = $query->uri;

        $articles = $this->articles->getAllAsPaginator(
            page: $page = $this->getPageByArgument($page),
            itemsPerPage: $this->itemsPerPage,
            category: $category = $this->findCategoryByArgument($categoryUri),
        );

        return new GetArticlesListOutput(
            page: $page,
            articles: ShortArticlesListOutput::fromArticlesPaginator($this->itemsPerPage, $articles),
            category: CategoryOutput::fromOptionalCategory($category),
        );
    }
}
