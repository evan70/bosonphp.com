<?php

namespace App\Documentation\Application\UseCase\GetVersionsList;

use App\Documentation\Application\Output\VersionsListOutput;

final readonly class GetVersionsListOutput
{
    public function __construct(
        public VersionsListOutput $versions,
    ) {}
}
