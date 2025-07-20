<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when a document is removed from the
 * Documentation domain.
 *
 * This event contains information about the removed document including
 * its version, category, title, URI, and content. It is typically dispatched
 * after a document has been successfully removed from the storage.
 */
final readonly class DocumentRemoved extends DocumentEvent {}
