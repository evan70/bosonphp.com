<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Twig\Provider;

use App\Documentation\Application\Output\Category\CategoryOutput;
use App\Documentation\Application\Output\Version\VersionOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameQuery;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\TerminableInterface;

final class DocsProvider implements TerminableInterface
{
    public ?VersionOutput $currentVersion {
        get => $this->versionByName?->version;
    }

    /**
     * @var iterable<array-key, CategoryOutput>
     */
    public iterable $categories {
        get => $this->currentVersion->categories ?? [];
    }

    public ?GetVersionByNameOutput $versionByName = null {
        get {
            try {
                /** @phpstan-ignore-next-line : PHPStan false-positive */
                return $this->versionByName ??= $this->queries->get(new GetVersionByNameQuery());
            } catch (\Throwable) {
                return null;
            }
        }
    }

    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function terminate(Request $request, Response $response): void
    {
        $this->versionByName = null;
    }
}
