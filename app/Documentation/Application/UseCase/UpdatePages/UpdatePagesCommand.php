<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdatePages;

use App\Documentation\Application\UseCase\UpdatePages\UpdatePagesIndexCommand\PageIndex;
use App\Shared\Domain\Bus\CommandId;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class UpdatePagesCommand
{
    /**
     * @var list<PageIndex>
     */
    public array $pages;

    /**
     * @param non-empty-string $version
     * @param iterable<array-key, PageIndex> $pages
     */
    public function __construct(
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $version,
        /**
         * @var non-empty-string
         */
        #[NotBlank(allowNull: false)]
        public string $category,
        iterable $pages = [],
        public CommandId $id = new CommandId(),
    ) {
        $this->pages = \iterator_to_array($pages, false);
    }
}
