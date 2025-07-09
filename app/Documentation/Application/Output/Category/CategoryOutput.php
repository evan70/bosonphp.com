<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Category;

use App\Documentation\Application\Output\Page\PageDocumentOutput;
use App\Documentation\Application\Output\Page\PageOutput;
use App\Documentation\Application\Output\Page\PagesListOutput;
use App\Documentation\Domain\Category\Category;

final class CategoryOutput
{
    public ?PageDocumentOutput $page = null {
        /** @phpstan-ignore-next-line : PHPStan false-positive, $items is list<T> */
        get => $this->page ??= \array_find($this->pages->items, static function (PageOutput $page): bool {
            return $page instanceof PageDocumentOutput;
        });
    }

    public function __construct(
        /**
         * @var non-empty-string
         */
        public readonly string $title,
        /**
         * @var non-empty-string|null
         */
        public readonly ?string $description,
        /**
         * @var non-empty-string|null
         */
        public readonly ?string $icon,
        public readonly PagesListOutput $pages,
    ) {}

    public static function fromCategory(Category $category): self
    {
        return new self(
            title: $category->title,
            description: $category->description,
            icon: $category->icon,
            pages: new \ReflectionClass(PagesListOutput::class)
                ->newLazyProxy(static function () use ($category): PagesListOutput {
                    return PagesListOutput::fromPages($category->pages);
                }),
        );
    }
}
