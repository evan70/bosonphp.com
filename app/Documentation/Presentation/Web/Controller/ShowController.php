<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Web\Controller;

use App\Documentation\Application\Query\GetDocumentationPageByNameQuery;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\Exception\PageNotFoundException;
use App\Documentation\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameResult;
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
#[Route('doc/{version}/{page}', name: 'doc.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly VersionsListProviderInterface $versions,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(string $version, string $page): Response
    {
        try {
            /** @var GetDocumentationPageByNameResult $result */
            $result = $this->queries->get(new GetDocumentationPageByNameQuery(
                name: $page,
                version: $version,
            ));
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Version "%s" not found', $version));
        } catch (PageNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Page "%s" not found', $page));
        }

        return $this->render('page/docs/show.html.twig', [
            'page' => $result->page,
            'version' => $result->version,
            'categories' => $result->categories,
            'versions' => $this->versions->getAll(),
        ]);
    }
}
