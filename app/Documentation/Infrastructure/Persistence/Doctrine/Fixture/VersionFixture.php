<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Fixture;

use App\Documentation\Domain\Version\Status;
use App\Documentation\Domain\Version\Version;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Fixture
 */
final class VersionFixture extends Fixture
{
    private const array VERSIONS = [
        '0.1',
        '0.2',
        '0.3',
        '0.4',
        '0.5',
        '0.6',
        '0.7',
        '0.8',
        '0.9',
        '0.10',
        '0.11',
        '0.12',
        '0.13',
        '0.14',
        '0.15',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::VERSIONS as $version) {
            $manager->persist(new Version(
                name: $version,
                status: match ($version) {
                    '0.15' => Status::Dev,
                    '0.14' => Status::Stable,
                    default => Status::Deprecated,
                }
            ));
        }

        $manager->flush();
    }
}
