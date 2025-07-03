<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Documentation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route('doc/{slug}', name: 'doc.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __invoke()
    {
        return $this->render('page/docs/show.html.twig', [

        ]);
    }
}
