<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\Page;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageLink;
use App\Shared\Application\Output\CollectionOutput;

/**
 * @template-extends CollectionOutput<PageOutput>
 */
final class PagesListOutput extends CollectionOutput
{
    /**
     * @param iterable<mixed, Page> $pages
     */
    public static function fromPages(iterable $pages): self
    {
        $result = [];

        foreach ($pages as $page) {
            $result[] = match (true) {
                $page instanceof PageDocument => PageDocumentOutput::fromPageDocument($page),
                $page instanceof PageLink => PageLinkOutput::fromPageLink($page),
                default => throw new \InvalidArgumentException('unsupported page type'),
            };
        }

        return new self($result);
    }
}
