<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Menu\PageMenu;
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
        $items = $manager->getRepository(PageMenu::class)
            ->findAll();

        for ($i = 0; $i < 10; ++$i) {
            $title = \rtrim($this->faker->sentence(
                $this->faker->numberBetween(1, 8)
            ), '.');

            /** @var PageMenu $item */
            foreach ($items as $item) {
                if (\random_int(0, 4) === 0) {
                    continue;
                }

                $manager->persist(match ($this->faker->numberBetween(0, 8)) {
                    0 => new PageLink(
                        menu: $item,
                        title: $title,
                        slugGenerator: $this->slugGenerator,
                    ),
                    default => new PageDocument(
                        menu: $item,
                        title: $title,
                        slugGenerator: $this->slugGenerator,
                        content: $this->faker->markdownContent(
                            $this->faker->numberBetween(5, 50),
                        )
                            . "\n\n"
                            . '> `menu:` ' . $item->title . "\n>\n"
                            . '> `menu_id:` ' . $item->id . "\n>\n"
                            . '> `ver:` ' . $item->version->name . "\n>\n",
                        contentRenderer: $this->renderer,
                    ),
                });
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
            DocMenuFixture::class,
        ];
    }
}
