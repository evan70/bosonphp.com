<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Article\Content\Content;
use App\Domain\Article\Content\RendererInterface;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @final impossible to specify "final" attribute natively due
 *        to a Doctrine bug https://github.com/doctrine/orm/issues/7598
 */
#[ORM\Entity]
#[ORM\Table(name: 'articles')]
#[ORM\UniqueConstraint(name: 'slug_unique', columns: ['slug'])]
class Article implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: ArticleId::class)]
    public private(set) ArticleId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title')]
    public string $title;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'slug')]
    public private(set) string $slug {
        get => $this->slug ?? throw new \LogicException(
            message: 'Сan\'t access to a "slug" property before persist an entity',
        );
    }

    #[ORM\Embedded(class: Content::class, columnPrefix: 'content_')]
    public Content $content {
        get => $this->content;
        set (string|\Stringable $value) {
            if (!isset($this->content)) {
                if ($value instanceof Content) {
                    $this->content = $value;
                    return;
                }

                throw new \LogicException('Could not initialize content instance');
            }

            $this->content->value = $value;
        }
    }

    /**
     * @param non-empty-string|\Stringable $title
     */
    public function __construct(
        string|\Stringable $title,
        string|\Stringable $content,
        RendererInterface $renderer,
        ?ArticleId $id = null,
    ) {
        $this->title = (string) $title;
        $this->content = new Content($content, $renderer);
        $this->id = $id ?? ArticleId::new();
    }
}
