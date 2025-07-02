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
#[ORM\Table(name: 'doc_menu')]
#[ORM\Index(name: 'doc_menu_sorting_order_idx', columns: ['sorting_order'])]
class Menu implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: MenuId::class)]
    public private(set) MenuId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(type: 'string', length: 255)]
    public string $title;

    /**
     * @var int<0, 32767>
     */
    #[ORM\Column(name: 'sorting_order', type: 'smallint')]
    public int $order = 0 {
        get => $this->order;
        set {
            if ($value < 0 || $value > 32767) {
                throw new \InvalidArgumentException('Order must be in range [0 ... 32767]');
            }

            $this->order = $value;
        }
    }

    /**
     * @var MenuSet
     */
    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'menu', cascade: ['ALL'], fetch: 'EAGER')]
    #[ORM\OrderBy(['order' => 'ASC'])]
    public iterable $pages {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => MenuSet::for($this, $this->pages);
    }

    /**
     * @param non-empty-string $title
     */
    public function __construct(
        string $title,
        ?MenuId $id = null,
    ) {
        $this->title = $title;
        $this->pages = new MenuSet($this);
        $this->id = $id ?? MenuId::new();
    }
}
