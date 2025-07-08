<?php

declare(strict_types=1);

namespace App\Blog\Presentation\Web\Controller;

use App\Blog\Application\UseCase\GetArticlesList\GetArticlesListQuery;
use App\Blog\Application\UseCase\GetArticlesList\Exception\InvalidPageException;
use App\Blog\Application\UseCase\GetArticlesList\GetArticlesListResult;
use App\Blog\Domain\Category\Repository\ArticleCategoryListProviderInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
        private readonly ArticleCategoryListProviderInterface $categories,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            /** @var GetArticlesListResult $result */
            $result = $this->queries->get(new GetArticlesListQuery(
                page: $request->query->getInt('page', 1),
            ));
        } catch (InvalidPageException) {
            throw new BadRequestHttpException('Articles page contain invalid value');
        }

        return $this->render('page/blog/index.html.twig', [
            'articles' => $result->articles,
            'page' => $result->page,
            'categories' => $this->categories->getAll(),
        ]);
    }
}
