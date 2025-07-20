<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when a new document is created in the
 * Documentation domain.
 *
 * This event contains information about the newly created document including
 * its version, category, title, URI, and content. It is typically dispatched
 * after a document has been successfully persisted to the storage.
 */
final readonly class DocumentCreated extends DocumentEvent {}
