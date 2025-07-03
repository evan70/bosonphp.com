<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use App\Domain\Documentation\Menu\Repository\PageMenuListProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('doc', name: 'doc.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly PageMenuListProviderInterface $menus,
    ) {}

    public function __invoke(): Response
    {
        return $this->render('page/docs/index.html.twig', [
            'menu' => $this->menus->getAll(),
        ]);
    }
}
