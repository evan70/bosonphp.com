<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Menu\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class DocMenuFixture extends Fixture
{
    public function __construct(
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 32; ++$i) {
            $manager->persist(new Menu(
                title: $this->faker->sentence(\random_int(1, 3)),
            ));
        }

        $manager->flush();
    }
}
