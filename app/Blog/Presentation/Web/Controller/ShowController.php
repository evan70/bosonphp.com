<?php

declare(strict_types=1);

namespace App\Blog\Presentation\Web\Controller;

use App\Blog\Application\Query\GetArticleByNameQuery;
use App\Blog\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Blog\Application\UseCase\GetArticleByName\Exception\InvalidArticleUriException;
use App\Blog\Application\UseCase\GetArticleByName\GetArticleByNameResult;
use App\Blog\Domain\Category\Repository\ArticleCategoryListProviderInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Presentation\Web\Controller
 */
#[Route('/blog/{slug}', name: 'blog.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
        private readonly ArticleCategoryListProviderInterface $categories,
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(string $slug): Response
    {
        try {
            /** @var GetArticleByNameResult $result */
            $result = $this->queries->get(new GetArticleByNameQuery($slug));
        } catch (InvalidArticleUriException) {
            throw new BadRequestHttpException('Article name contain invalid characters');
        } catch (ArticleNotFoundException) {
            throw new NotFoundHttpException(\sprintf('Article with name "%s" not found', $slug));
        }

        return $this->render('page/blog/show.html.twig', [
            'article' => $result->article,
            'categories' => $this->categories->getAll(),
        ]);
    }
}
