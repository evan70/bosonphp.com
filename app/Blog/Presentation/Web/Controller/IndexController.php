<?php

declare(strict_types=1);

namespace App\Blog\Presentation\Web\Controller;

use App\Blog\Application\UseCase\GetArticlesList\GetArticlesListOutput;
use App\Blog\Application\UseCase\GetArticlesList\GetArticlesListQuery;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListOutput;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListQuery;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Presentation\Web\Controller
 */
#[Route('/blog', name: 'blog.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            /** @var GetArticlesListOutput $articlesResult */
            $articlesResult = $this->queries->get(new GetArticlesListQuery(
                page: $request->query->getInt('page', 1),
            ));

            /** @var GetCategoriesListOutput $categoriesResult */
            $categoriesResult = $this->queries->get(new GetCategoriesListQuery());
        } catch (ValidationFailedException $e) {
            throw new BadRequestHttpException('Articles page contain invalid value', previous: $e);
        }

        return $this->render('page/blog/index.html.twig', [
            'articles' => $articlesResult->articles,
            'page' => $articlesResult->page,
            'categories' => $categoriesResult->categories,
        ]);
    }
}
