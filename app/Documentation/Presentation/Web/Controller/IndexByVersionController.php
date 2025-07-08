<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Web\Controller;

use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListQuery;
use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
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
#[Route('doc/{version}', name: 'doc.index_by_version', methods: 'GET')]
final class IndexByVersionController extends AbstractController
{
    public function __construct(
        private readonly VersionsListProviderInterface $versions,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(string $version): Response
    {
        try {
            /** @var GetDocumentationCategoriesListResult $result */
            $result = $this->queries->get(new GetDocumentationCategoriesListQuery(
                version: $version,
            ));
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Documentation version "%s" not found', $version));
        }

        return $this->render('page/docs/index.html.twig', [
            'version' => $result->version,
            'categories' => $result->categories,
            'versions' => $this->versions->getAll(),
        ]);
    }
}
