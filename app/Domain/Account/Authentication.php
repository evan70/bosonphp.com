<?php

declare(strict_types=1);

namespace App\Domain\Account;

use App\Domain\Account\Password\Password;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class Authentication implements
    UserInterface,
    EquatableInterface,
    PasswordAuthenticatedUserInterface,
    \Stringable
{
    public function __construct(
        public Account $account,
    ) {}

    public function isEqualTo(UserInterface $user): bool
    {
        $id = $this->account->id;

        return $user instanceof Account
            && $id->equals($user->id);
    }

    public function getPassword(): ?string
    {
        return $this->account->password->hash;
    }

    public function getRoles(): array
    {
        return $this->account->roles->toArray();
    }

    public function eraseCredentials(): void
    {
        $password = $this->account->password;

        // Match that password is open
        if (!$password instanceof Password) {
            return;
        }

        $this->account->password = $password->toEncrypted();
    }

    /**
     * @return non-empty-string
     */
    public function getUserIdentifier(): string
    {
        $id = $this->account->id;

        return $id->toString();
    }

    public function __toString(): string
    {
        return $this->account->login;
    }
}
