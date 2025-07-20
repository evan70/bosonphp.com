<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when a Link is removed from the
 * Documentation domain.
 *
 * This event contains information about the removed link including
 * its version, category, title, and URI. It is typically dispatched
 * after a link has been successfully removed from the storage.
 */
final readonly class LinkRemoved extends LinkEvent {}
