<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Base event class for all Link-related events in the Documentation domain.
 *
 * This abstract class extends PageEvent and provides a common base for all
 * link-related domain events. Link events represent changes to documentation
 * links and references.
 */
abstract readonly class LinkEvent extends PageEvent {}
