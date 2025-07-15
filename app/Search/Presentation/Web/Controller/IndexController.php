<?php

declare(strict_types=1);

namespace App\Search\Presentation\Web\Controller;

use App\Search\Application\UseCase\GetDocumentationSearchResults\GetDocumentationSearchResultsOutput;
use App\Search\Application\UseCase\GetDocumentationSearchResults\GetDocumentationSearchResultsQuery;
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
 * @psalm-internal App\Search\Presentation\Web\Controller
 */
#[Route('search', name: 'search.index', methods: 'GET')]
final class IndexController extends AbstractController
{
    public function __construct(
        private readonly QueryBusInterface $queries,
    ) {}

    public function __invoke(Request $request): Response
    {
        try {
            /** @var GetDocumentationSearchResultsOutput $result */
            $result = $this->queries->get(new GetDocumentationSearchResultsQuery(
                query: $request->query->get('q', ''),
            ));
        } catch (ValidationFailedException $e) {
            throw new BadRequestHttpException('Invalid query arguments', previous: $e);
        }

        return $this->render('page/search/index.html.twig', [
            'version' => $result->version,
            'results' => $result->results,
        ]);
    }
}
