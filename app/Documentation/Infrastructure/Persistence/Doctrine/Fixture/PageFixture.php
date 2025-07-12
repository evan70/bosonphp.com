<?php

declare(strict_types=1);

namespace App\Documentation\Infrastructure\Persistence\Doctrine\Fixture;

use App\Documentation\Domain\Category\Category;
use App\Documentation\Domain\PageDocument;
use App\Documentation\Domain\PageDocumentContentRendererInterface;
use App\Documentation\Domain\PageLink;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Documentation\Infrastructure\Persistence\Doctrine\Fixture
 */
final class PageFixture extends Fixture implements DependentFixtureInterface
{
    private const array PAGES = [
        'Configuration',
        'Events',
        'Application',
        'Window',
        'WebView',
        'Dialog API',
        'Custom Schemes',
        'Scheme Events',
        'Functions Bindings',
        'WebView Data Retrieving',
        'JavaScript Injection',
        'Web Components',
        'Battery Status',
        'Security Context',
    ];

    public function __construct(
        private readonly Generator $faker,
        private readonly PageDocumentContentRendererInterface $renderer,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)
            ->findAll();

        /** @var Category $category */
        foreach ($categories as $category) {
            /** @var list<non-empty-string> $titles */
            $titles = $this->faker->randomElements(
                self::PAGES,
                $this->faker->numberBetween(1, \count(self::PAGES)),
            );

            foreach ($titles as $title) {
                $manager->persist(match ($this->faker->numberBetween(0, 10)) {
                    0 => new PageLink(
                        category: $category,
                        title: $title . ' in ' . $category->title,
                        uri: 'https://www.google.com/search?q='
                            . \htmlspecialchars($title . ' in ' . $category->title),
                        order: $this->faker->numberBetween(0, 10),
                    ),
                    default => new PageDocument(
                        category: $category,
                        title: $title . ' in ' . $category->title,
                        uri: new AsciiSlugger()
                            ->slug($title . ' in ' . $category->title)
                            ->toString(),
                        content: $this->faker->markdownContent(
                            $this->faker->numberBetween(5, 50),
                        )
                            . "\n\n"
                            . '> `category:` ' . $category->title . "\n>\n"
                            . '> `category_id:` ' . $category->id . "\n>\n"
                            . '> `ver:` ' . $category->version->name . "\n>\n",
                        contentRenderer: $this->renderer,
                        order: $this->faker->numberBetween(0, 10),
                    ),
                });
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
