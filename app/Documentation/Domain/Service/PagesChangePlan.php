<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Service;

use App\Documentation\Domain\Event\PageEvent;
use App\Documentation\Domain\Page;

/**
 * Value object representing the result of a pages change computation.
 */
final readonly class PagesChangePlan
{
    /**
     * List of updated pages.
     *
     * @var list<Page>
     */
    public array $updated;

    /**
     * List of newly created pages.
     *
     * @var list<Page>
     */
    public array $created;

    /**
     * List of removed pages.
     *
     * @var list<Page>
     */
    public array $removed;

    /**
     * List of events describing the changes.
     *
     * @var list<PageEvent>
     */
    public array $events;

    /**
     * @param iterable<mixed, Page> $updated Updated pages
     * @param iterable<mixed, Page> $created Created pages
     * @param iterable<mixed, Page> $removed Removed pages
     * @param iterable<mixed, PageEvent> $events Events describing the changes
     */
    public function __construct(
        iterable $updated = [],
        iterable $created = [],
        iterable $removed = [],
        iterable $events = [],
    ) {
        $this->updated = \iterator_to_array($updated, false);
        $this->created = \iterator_to_array($created, false);
        $this->removed = \iterator_to_array($removed, false);
        $this->events = \iterator_to_array($events, false);
    }
}
