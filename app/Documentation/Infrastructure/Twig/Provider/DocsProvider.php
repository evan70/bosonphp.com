<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Twig\Provider;

use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListQuery;
use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class DocsProvider implements TerminableInterface
{
    public Version $currentVersion {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => $this->categoriesListResult->version;
    }

    /**
     * @var iterable<array-key, Category>
     */
    public iterable $categories {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => $this->categoriesListResult->categories;
    }

    public ?GetDocumentationCategoriesListResult $categoriesListResult = null {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => $this->categoriesListResult ??= $this->queries->get(new GetDocumentationCategoriesListQuery());
    }

    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function terminate(Request $request, Response $response): void
    {
        $this->categoriesListResult = null;
    }
}
