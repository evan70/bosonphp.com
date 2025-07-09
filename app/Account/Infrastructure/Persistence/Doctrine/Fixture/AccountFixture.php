<?php

declare(strict_types=1);

namespace App\Account\Infrastructure\Persistence\Doctrine\Fixture;

use App\Account\Domain\Account;
use App\Account\Domain\Password\Password;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Account\Infrastructure\Persistence\Doctrine\Fixture
 */
final class AccountFixture extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $account = new Account('admin');
        $account->password = Password::createForAccount('admin', $account, $this->hasher);

        $manager->persist($account);

        $manager->flush();
    }
}
