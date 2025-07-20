<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when a new Link is created in the
 * Documentation domain.
 *
 * This event contains information about the newly created link including
 * its version, category, title, and URI. It is typically dispatched
 * after a link has been successfully created and persisted to the storage.
 */
final readonly class LinkCreated extends LinkEvent {}
