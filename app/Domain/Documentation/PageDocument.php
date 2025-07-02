<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Menu\Menu;
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

    public function __construct(
        Menu $menu,
        string $title,
        PageSlugGeneratorInterface $slugGenerator,
        string|\Stringable $content,
        PageDocumentContentRendererInterface $contentRenderer,
        ?PageId $id = null,
    ) {
        $this->content = new PageDocumentContent($content, $contentRenderer);

        parent::__construct($menu, $title, $slugGenerator, $id);
    }
}
