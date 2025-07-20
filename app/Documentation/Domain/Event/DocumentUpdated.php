<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Event;

/**
 * Domain event that is dispatched when an existing document is updated in
 * the Documentation domain.
 *
 * This event contains information about the updated document including
 * its version, category, title, URI, and new content. It is typically dispatched
 * after a document has been successfully updated and persisted to the storage.
 */
final readonly class DocumentUpdated extends DocumentEvent {}
