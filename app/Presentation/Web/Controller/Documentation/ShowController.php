<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\Repository\PageByNameProviderInterface;
use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionByNameProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('doc/{version}/{page}', name: 'doc.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly CurrentVersionProviderInterface $currentVersions,
        private readonly VersionByNameProviderInterface $versionsByName,
        private readonly VersionsListProviderInterface $versionsList,
        private readonly PageByNameProviderInterface $pageByName,
    ) {}

    public function __invoke(string $version, string $page): Response
    {
        $versionInstance = $version === 'current'
            ? $this->currentVersions->findLatest()
            : $this->versionsByName->findVersionByName($version);

        if ($versionInstance === null) {
            throw new NotFoundHttpException(\sprintf('Version "%s" not found', $version));
        }

        /** @var PageDocument $pageInstance */
        $pageInstance = $this->pageByName->findByName($versionInstance, $page);

        if ($pageInstance === null) {
            throw new NotFoundHttpException(\sprintf('Page "%s" not found', $page));
        }

        return $this->render('page/docs/show.html.twig', [
            'versions' => $this->versionsList->getAll(),
            'version' => $versionInstance,
            'page' => $pageInstance,
            'categories' => $versionInstance?->categories ?? [],
        ]);
    }
}
