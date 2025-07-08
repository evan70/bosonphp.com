<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Web\Controller;

use App\Documentation\Application\Query\GetDocumentationCategoriesListQuery;
use App\Documentation\Application\UseCase\GetDocumentationCategoriesList\GetDocumentationCategoriesListResult;
use App\Documentation\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;
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
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly VersionsListProviderInterface $versions,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(): Response
    {
        try {
            /** @var GetDocumentationCategoriesListResult $result */
            $result = $this->queries->get(new GetDocumentationCategoriesListQuery());
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException('There are no available versions in the documentation');
        }

        return $this->render('page/docs/index.html.twig', [
            'version' => $result->version,
            'categories' => $result->categories,
            'versions' => $this->versions->getAll(),
        ]);
    }
}
