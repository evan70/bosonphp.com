<?php

declare(strict_types=1);

namespace App\Sync\Presentation\Api\Controller;

use App\Shared\Domain\Bus\CommandBusInterface;
use App\Sync\Application\UseCase\SyncVersions\SyncVersionsCommand;
use App\Sync\Presentation\Api\Controller\GitHubWebHookController\GitHubWebHookRequestDTO;
use App\Sync\Presentation\Api\Controller\GitHubWebHookController\GitHubWebHookResponseDTO;
use Local\Bridge\TypeLang\Attribute\MapRequest;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/doc/sync/github', methods: ['POST'])]
final readonly class GitHubWebHookController
{
    public function __construct(
        private CommandBusInterface $commands,
    ) {}

    public function __invoke(#[MapRequest] GitHubWebHookRequestDTO $request): GitHubWebHookResponseDTO
    {
        $this->commands->send(new SyncVersionsCommand());

        return new GitHubWebHookResponseDTO();
    }
}
