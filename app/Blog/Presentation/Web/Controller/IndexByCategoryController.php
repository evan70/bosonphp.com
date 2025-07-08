<?php

declare(strict_types=1);

namespace App\Blog\Presentation\Web\Controller;

use App\Blog\Application\Query\GetArticlesListQuery;
use App\Blog\Application\UseCase\GetArticlesList\Exception\CategoryNotFoundException;
use App\Blog\Application\UseCase\GetArticlesList\Exception\InvalidCategoryUriException;
use App\Blog\Application\UseCase\GetArticlesList\Exception\InvalidPageException;
use App\Blog\Application\UseCase\GetArticlesList\GetArticlesListResult;
use App\Blog\Domain\Category\Repository\ArticleCategoryListProviderInterface;
use App\Domain\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        try {
            /** @var GetArticlesListResult $result */
            $result = $this->queries->get(new GetArticlesListQuery(
                page: $request->query->getInt('page', 1),
                categoryUri: $slug,
            ));
        } catch (InvalidCategoryUriException) {
            throw new BadRequestHttpException('Category name contain invalid characters');
        } catch (InvalidPageException) {
            throw new BadRequestHttpException('Articles page contain invalid value');
        } catch (CategoryNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Category with name "%s" not found', $slug));
        }

        return $this->render('page/blog/index_by_category.html.twig', [
            'category' => $result->category,
            'articles' => $result->articles,
            'page' => $result->page,
            'categories' => $this->categories->getAll(),
        ]);
    }
}
