<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'home', methods: 'GET')]
final class HomeController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('page/home.html.twig');
    }
}
