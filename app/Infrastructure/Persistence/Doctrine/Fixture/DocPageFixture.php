<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture;

use App\Domain\Documentation\Menu\Menu;
use App\Domain\Documentation\PageDocument;
use App\Domain\Documentation\PageDocumentContentRendererInterface;
use App\Domain\Documentation\PageLink;
use App\Domain\Documentation\PageSlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

class DocPageFixture extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly Generator $faker,
        private readonly PageSlugGeneratorInterface $slugGenerator,
        private readonly PageDocumentContentRendererInterface $renderer,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $items = $manager->getRepository(Menu::class)
            ->findAll();

        /** @var Menu $item */
        foreach ($items as $item) {
            if (\random_int(0, 16) === 0) {
                continue;
            }

            $manager->persist(match (\random_int(0, 8)) {
                0 => new PageLink(
                    menu: $item,
                    title: $this->faker->sentence(\random_int(1, 8)),
                    slugGenerator: $this->slugGenerator,
                ),
                default => new PageDocument(
                    menu: $item,
                    title: $this->faker->sentence(\random_int(1, 8)),
                    slugGenerator: $this->slugGenerator,
                    content: $this->faker->text(
                        $this->faker->numberBetween(100, 1000),
                    ),
                    contentRenderer: $this->renderer,
                ),
            });
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
