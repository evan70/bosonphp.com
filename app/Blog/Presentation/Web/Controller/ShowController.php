<?php

declare(strict_types=1);

namespace App\Blog\Presentation\Web\Controller;

use App\Blog\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Blog\Application\UseCase\GetArticleByName\Exception\InvalidArticleUriException;
use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameOutput;
use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameQuery;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListOutput;
use App\Blog\Application\UseCase\GetCategoriesList\GetCategoriesListQuery;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Presentation\Web\Controller
 */
#[Route('/blog/{slug}', name: 'blog.show', requirements: ['slug' => Requirement::ASCII_SLUG], methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(string $slug): Response
    {
        try {
            /** @var GetArticleByNameOutput $articleResult */
            $articleResult = $this->queries->get(new GetArticleByNameQuery($slug));

            /** @var GetCategoriesListOutput $categoriesResult */
            $categoriesResult = $this->queries->get(new GetCategoriesListQuery());
        } catch (ValidationFailedException) {
            throw new BadRequestHttpException('Article name contain invalid characters');
        } catch (ArticleNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Article with name "%s" not found', $slug));
        }

        return $this->render('page/blog/show.html.twig', [
            'article' => $articleResult->article,
            'category' => $articleResult->category,
            'categories' => $categoriesResult->categories,
        ]);
    }
}
