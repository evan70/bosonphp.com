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
 * @internal this is an internal library class, please do not use it in your code.
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

        /** @var PageMenu $item */
        foreach ($items as $item) {
            $refCount = $this->faker->numberBetween(1, 10);

            for ($i = 0; $i < $refCount; $i++) {
                $manager->persist(match ($this->faker->numberBetween(0, 8)) {
                    0 => new PageLink(
                        menu: $item,
                        title: \rtrim($this->faker->sentence(
                            $this->faker->numberBetween(1, 8)
                        ), '.'),
                        slugGenerator: $this->slugGenerator,
                    ),
                    default => new PageDocument(
                        menu: $item,
                        title: \rtrim($this->faker->sentence(
                            $this->faker->numberBetween(1, 8),
                        ), '.'),
                        slugGenerator: $this->slugGenerator,
                        content: $this->faker->markdownContent(
                            $this->faker->numberBetween(5, 50),
                        ),
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
