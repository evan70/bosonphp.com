<?php

declare(strict_types=1);

namespace App\Shared\Presentation\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/old', name: 'redirect', methods: 'GET')]
final class HomeController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute('doc.index', status: Response::HTTP_TEMPORARY_REDIRECT);
    }
}
