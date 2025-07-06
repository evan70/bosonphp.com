<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Application\Query\GetDocumentationCategoriesListQuery;
use App\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

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
