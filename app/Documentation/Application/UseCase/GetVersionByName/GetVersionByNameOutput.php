<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetVersionByName;

use App\Documentation\Application\Output\Version\VersionOutput;

final readonly class GetVersionByNameOutput
{
    public function __construct(
        public VersionOutput $version,
    ) {}
}
