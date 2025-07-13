<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions;

use App\Documentation\Application\UseCase\UpdateVersions\UpdateVersionsCommand\VersionIndex;
use App\Shared\Domain\Bus\CommandId;

final readonly class UpdateVersionsCommand
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
