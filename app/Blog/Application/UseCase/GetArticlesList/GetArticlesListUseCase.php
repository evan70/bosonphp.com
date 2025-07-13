<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetArticlesList;

use App\Blog\Application\Output\Article\ShortArticlesListOutput;
use App\Blog\Application\Output\Category\CategoryOutput;
use App\Blog\Application\UseCase\GetArticlesList\Exception\CategoryNotFoundException;
use App\Blog\Domain\Category\Category;
use App\Blog\Domain\Category\Repository\CategoryByUriProviderInterface;
use App\Blog\Domain\Repository\ArticlesListPaginateProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetArticlesListUseCase
{
    public function __construct(
        private ArticlesListPaginateProviderInterface $articles,
        private CategoryByUriProviderInterface $categories,
        /**
         * @var int<1, max>
         */
        private int $itemsPerPage = ArticlesListPaginateProviderInterface::DEFAULT_ITEMS_PER_PAGE,
    ) {}

    private function findCategory(GetArticlesListQuery $query): ?Category
    {
        /** @var non-empty-string|null $categoryUri : Validated by constraint */
        $categoryUri = $query->uri;

        if ($categoryUri === null) {
            return null;
        }

        return $this->categories->findByUri($categoryUri)
            ?? throw new CategoryNotFoundException();
    }

    public function __invoke(GetArticlesListQuery $query): GetArticlesListOutput
    {
        /** @var int<1, 2147483647> $page : Validated by constraint */
        $page = $query->page;

        $category = $this->findCategory($query);

        $articles = $this->articles->getAllAsPaginator(
            page: $page,
            itemsPerPage: $this->itemsPerPage,
            category: $category,
        );

        return new GetArticlesListOutput(
            page: $page,
            articles: ShortArticlesListOutput::fromArticlesPaginator($this->itemsPerPage, $articles),
            category: CategoryOutput::fromOptionalCategory($category),
        );
    }
}
