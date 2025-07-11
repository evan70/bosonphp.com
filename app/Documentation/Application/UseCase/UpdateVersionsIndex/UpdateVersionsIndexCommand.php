<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\VersionIndex;
use App\Shared\Infrastructure\Bus\CommandBus\CommandId;

final readonly class UpdateVersionsIndexCommand
{
    /**
     * @var list<VersionIndex>
     */
    public array $versions;

    /**
     * @param iterable<mixed, VersionIndex> $versions
     */
    public function __construct(
        iterable $versions,
        public CommandId $id = new CommandId(),
    ) {
        $this->versions = \iterator_to_array($versions, false);
    }
}
