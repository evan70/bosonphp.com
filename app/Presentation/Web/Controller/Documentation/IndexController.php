<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use App\Domain\Documentation\Version\Repository\VersionsListProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('doc', name: 'doc.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly CurrentVersionProviderInterface $currentVersions,
        private readonly VersionsListProviderInterface $versionsList,
    ) {}

    public function __invoke(): Response
    {
        $version = $this->currentVersions->findLatest();
        $versions = $this->versionsList->getAll();

        return $this->render('page/docs/index.html.twig', [
            'version' => $version,
            'versions' => $versions,
            'menu' => $version?->menu ?? [],
        ]);
    }
}
