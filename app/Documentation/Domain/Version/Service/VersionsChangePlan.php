<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Version;

final readonly class VersionsChangePlan
{
    /**
     * @var list<Version>
     */
    public array $updated;

    /**
     * @var list<Version>
     */
    public array $created;

    /**
     * @var list<VersionEvent>
     */
    public array $events;

    /**
     * @param iterable<mixed, Version> $updated
     * @param iterable<mixed, Version> $created
     * @param iterable<mixed, VersionEvent> $events
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
