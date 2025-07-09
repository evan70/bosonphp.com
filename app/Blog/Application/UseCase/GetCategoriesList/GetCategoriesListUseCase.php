<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetCategoriesList;

use App\Blog\Application\Output\CategoriesListOutput;
use App\Blog\Domain\Category\Repository\CategoriesListProviderInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'query.bus')]
final readonly class GetCategoriesListUseCase
{
    public function __construct(
        private CategoriesListProviderInterface $categoryListProvider,
    ) {}

    public function __invoke(GetCategoriesListQuery $query): GetCategoriesListOutput
    {
        return new GetCategoriesListOutput(
            categories: CategoriesListOutput::fromCategories(
                categories: $this->categoryListProvider->getAll(),
            ),
        );
    }
}
