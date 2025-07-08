<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Fixture;

use App\Blog\Domain\Article;
use App\Blog\Domain\ArticleContentRendererInterface;
use App\Blog\Domain\ArticleSlugGeneratorInterface;
use App\Blog\Domain\Category\ArticleCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Fixture
 */
final class ArticleFixture extends Fixture implements DependentFixtureInterface
{
    private const array TITLES = [
        'Overview',
        'Getting Started',
        'Introduction',
        'Installation',
        'Release Notes',
        'The Basics',
        'Configuration',
        'Events',
        'Application',
        'Window',
        'WebView',
        'Application APIs',
        'Dialog API',
        'WebView APIs',
        'Custom Schemes',
        'Scheme Events',
        'Functions Bindings',
        'WebView Data Retrieving',
        'JavaScript Injection',
        'Web Components',
        'Battery Status',
        'Security Context',
        'Distribute',
        'Components',
        'Framework Integrations',
        'Examples',
        'Contribution Guide',
        'License',
    ];

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

        foreach ($categories as $category) {
            $items = $this->faker->numberBetween(1, 40);

            for ($i = 0; $i < $items; ++$i) {
                $manager->persist(new Article(
                    category: $category,
                    title: $this->faker->randomElement(self::TITLES)
                        . ' of ' . $category->title . ' ' . $i,
                    slugGenerator: $this->slugGenerator,
                    content: $this->faker->randomElement([
                        \file_get_contents(__DIR__ . '/ArticleFixture/article_fixture.01.md'),
                        \file_get_contents(__DIR__ . '/ArticleFixture/article_fixture.02.md'),
                        \file_get_contents(__DIR__ . '/ArticleFixture/article_fixture.03.md'),
                        $this->faker->markdownContent(
                            $this->faker->numberBetween(5, 50),
                        ),
                    ]),
                    contentRenderer: $this->contentRenderer,
                ));
            }

            $manager->flush();
        }

        $manager->flush();
    }

    /**
     * @return list<class-string<Fixture>>
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixture::class,
        ];
    }
}
