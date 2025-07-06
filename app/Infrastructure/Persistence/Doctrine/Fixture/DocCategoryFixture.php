<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\Version\Version;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Fixture
 */
final class DocCategoryFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $versions = $manager->getRepository(Version::class)
            ->findBy([], ['name' => 'ASC']); // Reverse order

        for ($i = 0; $i < 10; ++$i) {
            $title = \rtrim($this->faker->sentence(
                $this->faker->numberBetween(1, 3)
            ), '.');

            if ($this->faker->numberBetween(0, 10) === 0) {
                continue;
            }

            foreach ($versions as $version) {
                $category = new Category(
                    version: $version,
                    title: $title,
                    description: $this->faker->numberBetween(0, 1) === 0
                        ? \rtrim($this->faker->sentence($this->faker->numberBetween(3, 10)), '.')
                        : null,
                    icon: match ($this->faker->numberBetween(0, 4)) {
                        1 => 'https://intellij-icons.jetbrains.design/icons/PhpIcons/icons/expui/phpLocal_dark.svg',
                        2 => 'https://intellij-icons.jetbrains.design/icons/PhpIcons/icons/expui/phpUnit_dark.svg',
                        3 => 'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/run/testCustom_dark.svg',
                        4 => 'https://intellij-icons.jetbrains.design/icons/CidrGoogleIcons/icons/expui/googleTest_dark.svg',
                        default => null,
                    },
                );

                $category->order = $i;

                $manager->persist($category);
            }
        }

        $manager->flush();
    }

    /**
     * @return list<class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            DocVersionFixture::class,
        ];
    }
}
