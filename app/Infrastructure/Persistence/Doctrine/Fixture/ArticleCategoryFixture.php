<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Article\Category\ArticleCategory;
use App\Domain\Article\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ArticleCategoryFixture extends Fixture
{
    public function __construct(
        private readonly ArticleCategorySlugGeneratorInterface $slugGenerator,
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 16; ++$i) {
            $manager->persist(new ArticleCategory(
                title: $this->faker->sentence(\random_int(1, 6)),
                slugGenerator: $this->slugGenerator,
            ));
        }

        $manager->flush();
    }
}
