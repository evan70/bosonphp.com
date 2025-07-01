<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleContentRendererInterface;
use App\Domain\Article\ArticleSlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ArticleFixture extends Fixture
{
    public function __construct(
        private readonly ArticleContentRendererInterface $contentRenderer,
        private readonly ArticleSlugGeneratorInterface $slugGenerator,
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; ++$i) {
            $manager->persist(new Article(
                title: $this->faker->sentence(\random_int(1, 6)),
                slugGenerator: $this->slugGenerator,
                content: $this->faker->text(),
                contentRenderer: $this->contentRenderer,
            ));
        }

        $manager->flush();
    }
}
