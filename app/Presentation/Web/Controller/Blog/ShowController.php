<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\ArticleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog/{slug}', name: 'blog.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepositoryInterface $articles,
    ) {}

    public function __invoke(string $slug): Response
    {
        $article = $this->articles->findBySlug($slug)
            ?? throw new NotFoundHttpException('Article not found');

        return $this->render('page/blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
