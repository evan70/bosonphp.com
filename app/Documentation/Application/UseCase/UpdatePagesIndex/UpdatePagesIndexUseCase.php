<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePagesIndex;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdatePagesIndexUseCase
{
    public function __invoke(UpdatePagesIndexCommand $command): void
    {
        dump($command);
    }
}
