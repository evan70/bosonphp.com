<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\PageDocumentContentRendererInterface;
use App\Domain\Documentation\PageLink;
use App\Domain\Documentation\PageSlugGeneratorInterface;
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
final class DocPageFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly Generator $faker,
        private readonly PageSlugGeneratorInterface $slugGenerator,
        private readonly PageDocumentContentRendererInterface $renderer,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $categories = $manager->getRepository(Category::class)
            ->findAll();

        /** @var Category $category */
        foreach ($categories as $category) {
            for ($i = 0; $i < 10; ++$i) {
                $title = \rtrim($this->faker->sentence(
                    $this->faker->numberBetween(1, 8)
                ), '.');

                $manager->persist(match ($this->faker->numberBetween(0, 8)) {
                    0 => new PageLink(
                        category: $category,
                        title: $title,
                        uri: 'https://www.google.com/search?q='
                            . \htmlspecialchars(\rtrim($this->faker->sentence(
                                $this->faker->numberBetween(1, 8)
                            ), '.')),
                    ),
                    default => new PageDocument(
                        category: $category,
                        title: $title,
                        slugGenerator: $this->slugGenerator,
                        content: $this->faker->markdownContent(
                            $this->faker->numberBetween(5, 50),
                        )
                            . "\n\n"
                            . '> `category:` ' . $category->title . "\n>\n"
                            . '> `category_id:` ' . $category->id . "\n>\n"
                            . '> `ver:` ' . $category->version->name . "\n>\n",
                        contentRenderer: $this->renderer,
                    ),
                });

                if (\random_int(0, 4) === 0) {
                    continue;
                }
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
            DocCategoryFixture::class,
        ];
    }
}
