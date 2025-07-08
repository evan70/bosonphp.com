<?php

declare(strict_types=1);

namespace App\Account\Domain\Password;

use App\Account\Domain\Account;
use App\Account\Domain\Authentication;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Exception\InvalidPasswordException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Embeddable]
final class Password extends EncryptedPassword
{
    /**
     * @param non-empty-string $hash
     */
    public function __construct(
        #[\SensitiveParameter]
        public readonly string $raw,
        string $hash,
    ) {
        parent::__construct($hash);
    }

    /**
     * @api
     *
     * @param non-empty-string $value
     */
    public static function createForAuthentication(
        #[\SensitiveParameter]
        string $value,
        PasswordAuthenticatedUserInterface $authentication,
        UserPasswordHasherInterface $hasher,
    ): self {
        /** @var non-empty-string $hash */
        $hash = $hasher->hashPassword($authentication, $value);

        return new self($value, $hash);
    }

    /**
     * @api
     *
     * @param non-empty-string $value
     */
    public static function createForAccount(
        #[\SensitiveParameter]
        string $value,
        Account $account,
        UserPasswordHasherInterface $hasher,
    ): self {
        return self::createForAuthentication(
            value: $value,
            authentication: new Authentication($account),
            hasher: $hasher,
        );
    }

    /**
     * @api
     *
     * @throws InvalidPasswordException
     */
    public static function createForHasher(
        #[\SensitiveParameter]
        string $value,
        PasswordHasherInterface $hasher,
    ): self {
        $hash = $hasher->hash($value);

        if ($hash === '') {
            throw new InvalidPasswordException('Empty hash for password has been generated');
        }

        return new self($value, $hash);
    }

    public function equals(mixed $object): bool
    {
        if (!parent::equals($object)) {
            return false;
        }

        /** @var self $object */
        return $this->raw === $object->raw;
    }

    public function toEncrypted(): EncryptedPassword
    {
        return new EncryptedPassword($this->hash);
    }
}
