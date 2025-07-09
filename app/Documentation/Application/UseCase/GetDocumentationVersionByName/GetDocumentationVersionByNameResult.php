<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetDocumentationVersionByName;

use App\Documentation\Domain\Version\Version;

final readonly class GetDocumentationVersionByNameResult
{
    public function __construct(
        public Version $version,
    ) {}
}
