<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdatePagesUseCase
{
    public function __invoke(UpdatePagesCommand $command): void
    {
        dump($command);
    }
}
