<?php

declare(strict_types=1);

namespace App\Documentation\Application\Output\Version;

use App\Documentation\Application\Output\Category\CategoriesListOutput;
use App\Documentation\Domain\Version\Version;

final readonly class VersionOutput
{
    public function __construct(
        /**
         * @var non-empty-string
         */
        public string $name,
        public VersionStatusOutput $status,
        public CategoriesListOutput $categories,
    ) {}

    public static function fromVersion(Version $version): self
    {
        return new self(
            name: $version->name,
            status: VersionStatusOutput::fromStatus(
                status: $version->status,
            ),
            categories: new \ReflectionClass(CategoriesListOutput::class)
                ->newLazyProxy(static function () use ($version): CategoriesListOutput {
                    return CategoriesListOutput::fromCategories(
                        categories: $version->categories,
                    );
                }),
        );
    }
}
