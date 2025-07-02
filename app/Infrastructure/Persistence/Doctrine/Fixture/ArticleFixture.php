<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleContentRendererInterface;
use App\Domain\Article\ArticleSlugGeneratorInterface;
use App\Domain\Article\Category\ArticleCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class ArticleFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly ArticleContentRendererInterface $contentRenderer,
        private readonly ArticleSlugGeneratorInterface $slugGenerator,
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $categories = $manager
            ->getRepository(ArticleCategory::class)
            ->findAll();

        for ($i = 0; $i < 100; ++$i) {
            $manager->persist(new Article(
                category: $this->faker->randomElement(
                    $categories,
                ),
                title: $this->faker->sentence(
                    $this->faker->numberBetween(1, 10),
                ),
                slugGenerator: $this->slugGenerator,
                content: $this->faker->text(
                    $this->faker->numberBetween(100, 1000),
                ),
                contentRenderer: $this->contentRenderer,
            ));
        }

        $manager->flush();
    }

    /**
     * @return list<class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            ArticleCategoryFixture::class,
        ];
    }
}
