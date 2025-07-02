<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\Category\Repository\ArticleCategoryListProviderInterface;
use App\Domain\Blog\Repository\ArticlePaginateProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog', name: 'blog.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly ArticlePaginateProviderInterface $articles,
        private readonly ArticleCategoryListProviderInterface $categories,
    ) {}

    /**
     * @return int<1, 2147483647>
     */
    private function getCurrentPage(Request $request): int
    {
        $page = $request->query->getInt('page', 1);

        return \min(\max($page, 1), 2147483647);
    }

    public function __invoke(Request $request): Response
    {
        return $this->render('page/blog/index.html.twig', [
            'articles' => $this->articles->getAllAsPaginator(
                page: $page = $this->getCurrentPage($request),
            ),
            'categories' => $this->categories->getAll(),
            'page' => $page,
        ]);
    }
}
