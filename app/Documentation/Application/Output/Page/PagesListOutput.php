<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Page;

use App\Documentation\Domain\Document;
use App\Documentation\Domain\Link;
use App\Documentation\Domain\Page;
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
                $page instanceof Document => DocumentOutput::fromDocument($page),
                $page instanceof Link => LinkOutput::fromLink($page),
                default => throw new \InvalidArgumentException('unsupported page type'),
            };
        }

        return new self($result);
    }
}
