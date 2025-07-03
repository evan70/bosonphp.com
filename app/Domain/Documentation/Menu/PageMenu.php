<?php

declare(strict_types=1);

namespace App\Domain\Documentation\Menu;

use App\Domain\Documentation\Page;
use App\Domain\Shared\Date\CreatedDateProvider;
use App\Domain\Shared\Date\CreatedDateProviderInterface;
use App\Domain\Shared\Date\UpdatedDateProvider;
use App\Domain\Shared\Date\UpdatedDateProviderInterface;
use App\Domain\Shared\Id\IdentifiableInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_page_menus')]
#[ORM\Index(name: 'doc_page_menus_sorting_order_idx', columns: ['sorting_order'])]
class PageMenu implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: PageMenuId::class)]
    public private(set) PageMenuId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(type: 'string', length: 255)]
    public string $title;

    /**
     * @var int<-32768, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint', options: ['default' => 0])]
    public int $order = 0;

    /**
     * @var PageMenuSet
     */
    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'menu', cascade: ['ALL'], fetch: 'EAGER')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    public iterable $pages {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => PageMenuSet::for($this, $this->pages);
    }

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        string $title,
        ?PageMenuId $id = null,
    ) {
        $this->title = $title;
        $this->pages = new PageMenuSet($this);
        $this->id = $id ?? PageMenuId::new();
    }
}
