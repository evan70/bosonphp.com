<?php

declare(strict_types=1);

namespace App\Presentation\Web\Controller\Blog;

use App\Application\Query\GetArticleByNameQuery;
use App\Application\UseCase\GetArticleByName\Exception\ArticleNotFoundException;
use App\Application\UseCase\GetArticleByName\Exception\InvalidArticleUriException;
use App\Application\UseCase\GetArticleByName\GetArticleByNameResult;
use App\Domain\Shared\Bus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog/{slug}', name: 'blog.show', methods: 'GET')]
final class ShowController extends AbstractController
{
    public function __construct(
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
        ]);
    }
}
