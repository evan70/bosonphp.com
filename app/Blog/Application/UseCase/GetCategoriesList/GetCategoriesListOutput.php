<?php

declare(strict_types=1);

namespace App\Blog\Application\UseCase\GetCategoriesList;

use App\Blog\Application\Output\CategoriesListOutput;

final readonly class GetCategoriesListOutput
{
    public function __construct(
        public CategoriesListOutput $categories,
    ) {}
}
