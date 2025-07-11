<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\IndexVersion;
use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

final readonly class UpdateVersionsIndexCommand
{
    /**
     * @var list<IndexVersion>
     */
    public array $versions;

    /**
     * @param iterable<mixed, IndexVersion> $versions
     */
    public function __construct(
        iterable $versions,
        public CommandId $id = new CommandId(),
    ) {
        $this->versions = \iterator_to_array($versions, false);
    }
}
