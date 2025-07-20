<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\GetPageByName;

use App\Documentation\Application\Output\Category\CategoryOutput;
use App\Documentation\Application\Output\Page\DocumentOutput;
use App\Documentation\Application\Output\Version\VersionOutput;

final readonly class GetPageByNameOutput
{
    public function __construct(
        public VersionOutput $version,
        public CategoryOutput $category,
        public DocumentOutput $page,
    ) {}
}
