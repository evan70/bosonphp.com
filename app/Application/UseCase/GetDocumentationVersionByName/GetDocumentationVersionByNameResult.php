<?php

declare(strict_types=1);

namespace App\Application\UseCase\GetDocumentationVersionByName;

use App\Domain\Documentation\Version\Version;

final readonly class GetDocumentationVersionByNameResult
{
    public function __construct(
        public Version $version,
    ) {}
}
