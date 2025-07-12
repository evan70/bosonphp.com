<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Documentation\Domain\Category\Category;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
class PageDocument extends Page
{
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

    /**
     * @param non-empty-string $title
     * @param non-empty-string $uri
     * @param int<-32768, 32767> $order
     * @param non-empty-lowercase-string|null $hash
     */
    public function __construct(
        Category $category,
        string $title,
        string $uri,
        string|\Stringable $content,
        PageDocumentContentRendererInterface $contentRenderer,
        int $order = 0,
        ?string $hash = null,
        ?PageId $id = null,
    ) {
        $this->content = new PageDocumentContent(
            value: $content,
            contentRenderer: $contentRenderer,
        );

        parent::__construct(
            title: $title,
            uri: $uri,
            category: $category,
            order: $order,
            hash: $hash,
            id: $id,
        );
    }
}
