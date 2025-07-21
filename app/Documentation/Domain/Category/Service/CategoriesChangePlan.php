<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Category\Service;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\Category\Event\CategoryEvent;

final readonly class CategoriesChangePlan
{
    /**
     * @var list<Category>
     */
    public array $updated;

    /**
     * @var list<Category>
     */
    public array $created;

    /**
     * @var list<Category>
     */
    public array $removed;

    /**
     * @var list<CategoryEvent>
     */
    public array $events;

    /**
     * @param iterable<mixed, Category> $updated
     * @param iterable<mixed, Category> $created
     * @param iterable<mixed, Category> $removed
     * @param iterable<mixed, CategoryEvent> $events
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
