<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Version\Version;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Fixture
 */
final class DocVersionFixture extends Fixture
{
    public function __construct(
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($major = 0; $major < 7; ++$major) {
            $maxMinorValue = $this->faker->numberBetween(1, 20);

            for ($minor = 0; $minor < $maxMinorValue; ++$minor) {
                if ($major === 0 && $minor === 0) {
                    continue;
                }

                $manager->persist(new Version(
                    title: \sprintf('%d.%d', $major, $minor),
                ));
            }
        }

        $manager->flush();
    }
}
