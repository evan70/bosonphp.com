<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionByNameProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('doc/{version}', name: 'doc.index_by_version', methods: 'GET')]
final class IndexByVersionController extends AbstractController
{
    public function __construct(
        private readonly CurrentVersionProviderInterface $currentVersions,
        private readonly VersionByNameProviderInterface $versionsByName,
        private readonly VersionsListProviderInterface $versionsList,
    ) {}

    public function __invoke(string $version): Response
    {
        $instance = $version === 'current'
            ? $this->currentVersions->findLatest()
            : $this->versionsByName->findVersionByName($version);

        if ($instance === null) {
            throw new NotFoundHttpException(\sprintf('Version "%s" not found', $version));
        }

        return $this->render('page/docs/index.html.twig', [
            'versions' => $this->versionsList->getAll(),
            'version' => $instance,
            'categories' => $instance?->categories ?? [],
        ]);
    }
}
