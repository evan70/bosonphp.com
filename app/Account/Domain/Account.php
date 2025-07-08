<?php

declare(strict_types=1);

namespace App\Account\Domain;

use App\Account\Domain\Integration\Integration;
use App\Account\Domain\Password\EncryptedPassword;
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
#[ORM\Table(name: 'accounts')]
#[ORM\UniqueConstraint(name: 'login_unique', columns: ['login'])]
class Account implements
    IdentifiableInterface,
    CreatedDateProviderInterface,
    UpdatedDateProviderInterface
{
    use CreatedDateProvider;
    use UpdatedDateProvider;

    #[ORM\Id]
    #[ORM\Column(type: AccountId::class)]
    public private(set) AccountId $id;

    /**
     * @var non-empty-string
     */
    #[ORM\Column(type: 'string', unique: true)]
    public string $login;

    #[ORM\Embedded(class: EncryptedPassword::class, columnPrefix: false)]
    public EncryptedPassword $password;

    /**
     * @var AccountRolesSet
     */
    #[ORM\Column(name: 'roles', type: 'string[]', options: ['default' => '{}'])]
    public private(set) iterable $roles {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => AccountRolesSet::for($this, $this->roles);
    }

    /**
     * @var AccountIntegrationsSet
     */
    #[ORM\OneToMany(targetEntity: Integration::class, mappedBy: 'account', cascade: ['ALL'], orphanRemoval: true)]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    public private(set) iterable $integrations {
        /** @phpstan-ignore-next-line : PHPStan false-positive */
        get => AccountIntegrationsSet::for($this, $this->integrations);
    }

    /**
     * @param non-empty-string $login
     * @param iterable<array-key, non-empty-string>|non-empty-string $roles
     */
    public function __construct(
        string $login,
        EncryptedPassword $password = new EncryptedPassword(),
        iterable|string $roles = [],
        ?AccountId $id = null,
    ) {
        $this->login = $login;
        $this->password = $password;
        $this->id = $id ?? AccountId::new();
        $this->integrations = new AccountIntegrationsSet($this);

        /** @phpstan-ignore-next-line : PHPStan false-positive */
        $this->roles = match (true) {
            \is_iterable($roles) => \iterator_to_array($roles, false),
            default => [$roles],
        };
    }
}
