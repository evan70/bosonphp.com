<?php

declare(strict_types=1);

namespace App\Domain\Documentation;

use App\Domain\Documentation\Category\Category;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_pages')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string', enumType: PageType::class)]
#[ORM\DiscriminatorMap([
    PageType::Document->value => PageDocument::class,
    PageType::Link->value => PageLink::class,
])]
#[ORM\Index(name: 'doc_pages_uri_idx', columns: ['uri'])]
abstract class Page implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: PageId::class)]
    public private(set) PageId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    public string $title;

    /**
     * @var non-empty-string
     */
    abstract public string $uri {
        get;
    }

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ['ALL'], fetch: 'EAGER', inversedBy: 'pages')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id', nullable: false)]
    public Category $category {
        get => $this->category;
        set(Category $new) {
            /** @phpstan-ignore-next-line : PHPStan false-positive */
            $previous = $this->category ?? null;

            if ($previous !== $new) {
                $previous?->pages->removeElement($this);

                $this->category = $new;
                $new->pages->add($this);
            }
        }
    }

    /**
     * @api
     */
    public bool $isLink {
        get => $this instanceof PageLink;
    }

    /**
     * @param non-empty-string $title
     * @param int<-32768, 32767> $order
     */
    public function __construct(
        string $title,
        Category $category,
        int $order = 0,
        ?PageId $id = null,
    ) {
        $this->title = $title;
        $this->order = $order;
        $this->category = $category;
        $this->id = $id ?? PageId::new();
    }
}
