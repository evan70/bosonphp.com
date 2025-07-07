<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Category\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
class PageDocument extends Page
{
    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255)]
    public string $title {
        get => $this->title;
        set(string|\Stringable $value) {
            $title = (string) $value;

            assert($title !== '', 'Documentation page title cannot be empty');

            $this->title = $title;
            $this->uri = $this->slugGenerator->createSlug($this);
        }
    }

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'uri', length: 255)]
    public protected(set) string $uri;

    #[ORM\Embedded(class: PageDocumentContent::class, columnPrefix: 'content_')]
    public PageDocumentContent $content {
        get => $this->content;
        set(string|\Stringable $value) {
            /** @phpstan-ignore-next-line : PHPStan false-positive in isset() */
            if (!isset($this->content) && $value instanceof PageDocumentContent) {
                $this->content = $value;

                return;
            }

            $this->content->value = $value;
        }
    }

    public function __construct(
        Category $category,
        string $title,
        private readonly PageSlugGeneratorInterface $slugGenerator,
        string|\Stringable $content,
        PageDocumentContentRendererInterface $contentRenderer,
        ?PageId $id = null,
    ) {
        $this->title = $title;

        $this->content = new PageDocumentContent(
            value: $content,
            contentRenderer: $contentRenderer,
        );

        parent::__construct($category, $id);
    }
}
