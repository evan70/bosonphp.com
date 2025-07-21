<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Version;

/**
 * Value object representing the result of a version change computation.
 */
final readonly class VersionsChangePlan
{
    /**
     * @var list<Version> List of updated versions
     */
    public array $updated;

    /**
     * @var list<Version> List of newly created versions
     */
    public array $created;

    /**
     * @var list<VersionEvent> List of events describing the changes
     */
    public array $events;

    /**
     * @param iterable<mixed, Version> $updated Updated versions
     * @param iterable<mixed, Version> $created Created versions
     * @param iterable<mixed, VersionEvent> $events Events describing the changes
     */
    public function __construct(
        iterable $updated = [],
        iterable $created = [],
        iterable $events = [],
    ) {
        $this->updated = \iterator_to_array($updated, false);
        $this->created = \iterator_to_array($created, false);
        $this->events = \iterator_to_array($events, false);
    }
}
