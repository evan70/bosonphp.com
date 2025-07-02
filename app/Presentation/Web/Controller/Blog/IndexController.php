<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\ArticleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog', name: 'blog.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articles,
    ) {}

    public function __invoke(): Response
    {
        $articles = $this->articles->getAllAsPaginator();

        return $this->render('page/blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
