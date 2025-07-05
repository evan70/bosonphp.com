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
                    title: $title . ' (v' . $version->name . ')',
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
