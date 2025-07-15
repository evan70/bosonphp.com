<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

interface PageTitleExtractorInterface
{
    /**
     * @return non-empty-string
     */
    public function extractTitle(Page $page): string;
}
