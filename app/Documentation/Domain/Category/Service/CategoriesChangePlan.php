<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryEvent;

/**
 * Value object representing the result of a category change computation.
 */
final readonly class CategoriesChangePlan
{
    /**
     * List of updated categories.
     *
     * @var list<Category>
     */
    public array $updated;

    /**
     * List of newly created categories.
     *
     * @var list<Category>
     */
    public array $created;

    /**
     * List of removed categories.
     *
     * @var list<Category>
     */
    public array $removed;

    /**
     * List of events describing the changes.
     *
     * @var list<CategoryEvent>
     */
    public array $events;

    /**
     * @param iterable<mixed, Category> $updated Updated categories
     * @param iterable<mixed, Category> $created Created categories
     * @param iterable<mixed, Category> $removed Removed categories
     * @param iterable<mixed, CategoryEvent> $events Events describing the changes
     */
    public function __construct(
        iterable $updated = [],
        iterable $created = [],
        iterable $removed = [],
        iterable $events = [],
    ) {
        $this->updated = \iterator_to_array($updated, false);
        $this->created = \iterator_to_array($created, false);
        $this->removed = \iterator_to_array($removed, false);
        $this->events = \iterator_to_array($events, false);
    }
}
