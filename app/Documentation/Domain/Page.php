<?php

declare(strict_types=1);

namespace App\Documentation\Domain;

use App\Documentation\Domain\Category\Category;
use App\Shared\Domain\Date\CreatedDateProvider;
use App\Shared\Domain\Date\CreatedDateProviderInterface;
use App\Shared\Domain\Date\UpdatedDateProvider;
use App\Shared\Domain\Date\UpdatedDateProviderInterface;
use App\Shared\Domain\Id\IdentifiableInterface;
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
#[ORM\UniqueConstraint(name: 'doc_pages_uri_unique', columns: ['uri', 'category_id'])]
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
    #[ORM\Column(name: 'title', type: 'non_empty_string', length: 255, nullable: false)]
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
    #[ORM\Column(name: 'sorting_order', type: 'int8', options: ['default' => 0])]
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
