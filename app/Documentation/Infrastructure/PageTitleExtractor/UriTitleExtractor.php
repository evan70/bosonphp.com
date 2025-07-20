<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\PageTitleExtractor;

use App\Documentation\Domain\Link;
use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageTitleExtractorInterface;
use Symfony\Component\String\UnicodeString;

final readonly class UriTitleExtractor implements PageTitleExtractorInterface
{
    public function extractTitle(Page $page): string
    {
        if ($page instanceof Link) {
            return $page->uri;
        }

        /** @var non-empty-string */
        return new UnicodeString(\pathinfo($page->uri, \PATHINFO_FILENAME))
            ->replaceMatches('/\W/', ' ')
            ->toString();
    }
}
