<?php

declare(strict_types=1);

namespace App\Documentation\Presentation\Web\Controller;

use App\Documentation\Application\UseCase\GetPageByName\Exception\PageNotFoundException;
use App\Documentation\Application\UseCase\GetPageByName\GetPageByNameOutput;
use App\Documentation\Application\UseCase\GetPageByName\GetPageByNameQuery;
use App\Documentation\Application\UseCase\GetVersionByName\Exception\VersionNotFoundException;
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
#[Route('doc/{version}/{page}.md', methods: 'GET')]
#[Route('doc/{version}/{page}', name: 'doc.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(string $version, string $page): Response
    {
        try {
            /** @var GetPageByNameOutput $pageResult */
            $pageResult = $this->queries->get(new GetPageByNameQuery(
                name: $page,
                version: $version,
            ));

            /** @var GetVersionsListOutput $versionsResult */
            $versionsResult = $this->queries->get(new GetVersionsListQuery());
        } catch (VersionNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Version "%s" not found', $version));
        } catch (PageNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Page "%s" not found', $page));
        }

        return $this->render('page/docs/show.html.twig', [
            'page' => $pageResult->page,
            'version' => $pageResult->version,
            'category' => $pageResult->category,
            'categories' => $pageResult->version->categories,
            'versions' => $versionsResult->versions,
        ]);
    }
}
