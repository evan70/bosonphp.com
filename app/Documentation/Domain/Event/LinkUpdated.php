<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when an existing Link is updated in
 * the Documentation domain.
 *
 * This event contains information about the updated link including
 * its version, category, title, and URI. It is typically dispatched
 * after a link has been successfully updated and persisted to the storage.
 */
final readonly class LinkUpdated extends LinkEvent {}
