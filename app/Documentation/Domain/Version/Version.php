<?php

declare(strict_types=1);

namespace App\Documentation\Domain\Version;

use App\Documentation\Domain\Category\Category;
use App\Shared\Domain\AggregateRootInterface;
use App\Shared\Domain\Date\CreatedDateProvider;
use App\Shared\Domain\Date\CreatedDateProviderInterface;
use App\Shared\Domain\Date\UpdatedDateProvider;
use App\Shared\Domain\Date\UpdatedDateProviderInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'doc_page_versions')]
#[ORM\UniqueConstraint(name: 'doc_page_versions_unique_idx', columns: ['name'])]
class Version implements
    AggregateRootInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: VersionId::class)]
    public private(set) VersionId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(name: 'name', type: 'string')]
    public string $name;

    /**
     * @var non-empty-lowercase-string
     */
    #[ORM\Column(name: 'hash', type: 'string', nullable: true)]
    public ?string $hash = null;

    #[ORM\Column(name: 'status', type: Status::class)]
    public Status $status = Status::DEFAULT;

    public bool $isHidden {
        get => $this->status === Status::Hidden;
    }

    /**
     * @var VersionCategoriesSet
     */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'version', cascade: ['ALL'], fetch: 'EAGER')]
    #[ORM\OrderBy(['id' => 'ASC'])]
    public iterable $categories {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => VersionCategoriesSet::for($this, $this->categories);
    }

    /**
     * @param non-empty-string $name
     * @param non-empty-lowercase-string $hash
     */
    public function __construct(
        string $name,
        Status $status = Status::DEFAULT,
        ?string $hash = null,
        ?VersionId $id = null,
    ) {
        $this->name = $name;
        $this->status = $status;
        $this->hash = $hash;
        $this->categories = new VersionCategoriesSet($this);
        $this->id = $id ?? VersionId::new();
    }

    public function disable(): void
    {
        $this->status = Status::Hidden;
    }

    public function enable(): void
    {
        $this->status = Status::Dev;
    }
}
