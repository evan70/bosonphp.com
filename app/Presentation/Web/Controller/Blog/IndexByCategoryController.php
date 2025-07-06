<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Application\Query\GetArticlesListQuery;
use App\Application\UseCase\GetArticlesList\GetArticlesListResult;
use App\Domain\Blog\Category\Repository\ArticleCategoryListProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog/category/{slug}', name: 'blog.index_by_category', methods: 'GET')]
final class IndexByCategoryController extends AbstractController
{
    public function __construct(
        private readonly ArticleCategoryListProviderInterface $categories,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(Request $request, string $slug): Response
    {
        /** @var GetArticlesListResult $result */
        $result = $this->queries->get(new GetArticlesListQuery(
            page: $request->query->getInt('page', 1),
            categoryUri: $slug,
        ));

        return $this->render('page/blog/index_by_category.html.twig', [
            'category' => $result->category,
            'articles' => $result->articles,
            'page' => $result->page,
            'categories' => $this->categories->getAll(),
        ]);
    }
}
