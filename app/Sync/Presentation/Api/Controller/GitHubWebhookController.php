<?php

declare(strict_types=1);

namespace App\Sync\Presentation\Api\Controller;

use App\Shared\Domain\Bus\CommandBusInterface;
use App\Shared\Domain\Bus\QueryBusInterface;
use App\Sync\Application\UseCase\GitHubWebhookValidate\GitHubWebhookValidateOutput;
use App\Sync\Application\UseCase\GitHubWebhookValidate\GitHubWebhookValidateQuery;
use App\Sync\Application\UseCase\SyncVersions\SyncVersionsCommand;
use App\Sync\Presentation\Api\Controller\GitHubWebhookController\GitHubWebhookRequestDTO;
use App\Sync\Presentation\Api\Controller\GitHubWebhookController\GitHubWebhookResponseDTO;
use Local\Bridge\RequestMapper\Attribute\MapRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/doc/sync/github', methods: ['POST'])]
final readonly class GitHubWebhookController
{
    public function __construct(
        private CommandBusInterface $commands,
        private QueryBusInterface $queries,
    ) {}

    public function __invoke(
        Request $request,
        #[MapRequest]
        GitHubWebhookRequestDTO $dto,
    ): GitHubWebhookResponseDTO {
        /** @var GitHubWebhookValidateOutput $result */
        $result = $this->queries->get(new GitHubWebhookValidateQuery(
            headers: $request->headers->all(),
            body: $request->getContent(),
        ));

        if ($result->isValid === false) {
            throw new AccessDeniedHttpException('Invalid GitHub WebHook Signature');
        }

        $this->commands->send(new SyncVersionsCommand());

        return new GitHubWebhookResponseDTO();
    }
}
