<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Web\Controller;

use App\Documentation\Application\UseCase\GetVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameOutput;
use App\Documentation\Application\UseCase\GetVersionByName\GetVersionByNameQuery;
use App\Documentation\Application\UseCase\GetVersionsList\GetVersionsListOutput;
use App\Documentation\Application\UseCase\GetVersionsList\GetVersionsListQuery;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Presentation\Web\Controller
 */
#[Route('doc', name: 'doc.index', methods: 'GET')]
#[Route('doc/{version}', name: 'doc.index_by_version', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(?string $version): Response
    {
        try {
            /** @var GetVersionByNameOutput $versionResult */
            $versionResult = $this->queries->get(new GetVersionByNameQuery($version));

            /** @var GetVersionsListOutput $versionsListResult */
            $versionsListResult = $this->queries->get(new GetVersionsListQuery());
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException('There are no available versions in the documentation');
        }

        return $this->render('page/docs/index.html.twig', [
            'version' => $versionResult->version,
            'versions' => $versionsListResult->versions,
        ]);
    }
}
