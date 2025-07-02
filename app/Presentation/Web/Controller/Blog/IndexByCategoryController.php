<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Domain\Blog\Category\Repository\ArticleCategoryBySlugProviderInterface;
use App\Domain\Blog\Category\Repository\ArticleCategoryListProviderInterface;
use App\Domain\Blog\Repository\ArticlePaginateProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog/category/{slug}', name: 'blog.index_by_category', methods: 'GET')]
final class IndexByCategoryController extends AbstractController
{
    public function __construct(
        private readonly ArticlePaginateProviderInterface $articles,
        private readonly ArticleCategoryBySlugProviderInterface $categoryBySlug,
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

    public function __invoke(Request $request, string $slug): Response
    {
        $category = $this->categoryBySlug->findBySlug($slug)
            ?? throw new NotFoundHttpException('Category not found');

        return $this->render('page/blog/index_by_category.html.twig', [
            'category' => $category,
            'articles' => $this->articles->getAllAsPaginator(
                page: $page = $this->getCurrentPage($request),
                category: $category,
            ),
            'categories' => $this->categories->getAll(),
            'page' => $page,
        ]);
    }
}
