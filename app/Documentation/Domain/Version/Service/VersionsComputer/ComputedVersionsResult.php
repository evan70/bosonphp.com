<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version\Service\VersionsComputer;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Version;

/**
 * Value object representing the result of version computation operations.
 *
 * This value object encapsulates the result of version computation services,
 * containing the versions that need to be persisted and the events that need
 * to be dispatched. It serves as a data transfer object between domain services
 * and the application layer.
 */
final readonly class ComputedVersionsResult
{
    /**
     * @var list<Version>
     */
    public array $versions;

    /**
     * @var list<VersionEvent>
     */
    public array $events;

    /**
     * Creates a new computation result with versions and events.
     *
     * This constructor takes iterables of versions and events and converts
     * them to arrays for easy access. The versions represent entities that
     * need to be persisted, and the events represent domain events that
     * need to be dispatched.
     *
     * @param iterable<mixed, Version> $versions Versions that need to be persisted
     * @param iterable<mixed, VersionEvent> $events Events that need to be dispatched
     */
    public function __construct(
        iterable $versions,
        iterable $events,
    ) {
        $this->versions = \iterator_to_array($versions, false);
        $this->events = \iterator_to_array($events, false);
    }
}
