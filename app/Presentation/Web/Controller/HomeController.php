<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller;

use App\Domain\Documentation\Version\Repository\CurrentVersionProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'home', methods: 'GET')]
final class HomeController extends AbstractController
{
    public function __construct(
        private readonly CurrentVersionProviderInterface $versions,
    ) {}

    public function __invoke(): Response
    {
        $version = $this->versions->findLatest();

        return $this->render('page/home.html.twig', [
            'version' => $version,
            'menu' => $version?->menu ?? null,
        ]);
    }
}
