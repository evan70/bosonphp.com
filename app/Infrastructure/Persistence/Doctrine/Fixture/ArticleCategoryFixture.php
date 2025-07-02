<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code.
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Fixture
 */
final class ArticleCategoryFixture extends Fixture
{
    public function __construct(
        private readonly ArticleCategorySlugGeneratorInterface $slugGenerator,
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 16; ++$i) {
            $manager->persist(new ArticleCategory(
                title: $this->faker->sentence($this->faker->numberBetween(1, 6)),
                slugGenerator: $this->slugGenerator,
            ));
        }

        $manager->flush();
    }
}
