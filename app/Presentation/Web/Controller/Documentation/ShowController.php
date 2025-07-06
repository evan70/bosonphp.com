<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Application\Query\GetDocumentationPageByNameQuery;
use App\Application\UseCase\GetDocumentationPageByName\Exception\PageNotFoundException;
use App\Application\UseCase\GetDocumentationPageByName\GetDocumentationPageByNameResult;
use App\Application\UseCase\GetDocumentationVersionByName\Exception\VersionNotFoundException;
use App\Domain\Documentation\PageLink;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

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

        if ($result->page instanceof PageLink) {
            return new RedirectResponse($result->page->slug);
        }

        return $this->render('page/docs/show.html.twig', [
            'page' => $result->page,
            'version' => $result->version,
            'categories' => $result->categories,
            'versions' => $this->versions->getAll(),
        ]);
    }
}
