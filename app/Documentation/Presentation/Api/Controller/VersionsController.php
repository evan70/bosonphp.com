<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Api\Controller;

use App\Documentation\Application\UseCase\GetVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameQuery;
use App\Documentation\Application\UseCase\GetVersionsList\GetVersionsListOutput;
use App\Documentation\Application\UseCase\GetVersionsList\GetVersionsListQuery;
use App\Documentation\Presentation\Api\Controller\VersionsController\VersionsResponseDTO;
use App\Documentation\Presentation\Api\Response\DTO\VersionResponseDTO;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/doc/versions')]
final readonly class VersionsController
{
    public function __construct(
        private QueryBusInterface $queries,
    ) {}

    public function __invoke(): VersionsResponseDTO
    {
        try {
            /** @var GetVersionByNameOutput $currentVersionResult */
            $currentVersionResult = $this->queries->get(new GetVersionByNameQuery());

            /** @var GetVersionsListOutput $versionsListResult */
            $versionsListResult = $this->queries->get(new GetVersionsListQuery());
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException('There are no available versions in the documentation');
        }

        return new VersionsResponseDTO(
            current: new VersionResponseDTO(
                version: $currentVersionResult->version->name,
            ),
        );
    }
}
