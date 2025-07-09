<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Twig\Provider;

use App\Blog\Application\Output\CategoriesListOutput;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListOutput;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListQuery;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class BlogProvider implements TerminableInterface
{
    public CategoriesListOutput $categories {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => $this->categoriesListOutput->categories;
    }

    private ?GetCategoriesListOutput $categoriesListOutput = null {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => $this->categoriesListOutput ??= $this->queries->get(new GetCategoriesListQuery());
    }

    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function terminate(Request $request, Response $response): void
    {
        $this->categoriesListOutput = null;
    }
}
