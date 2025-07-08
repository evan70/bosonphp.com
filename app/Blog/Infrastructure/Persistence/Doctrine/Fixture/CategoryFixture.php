<?php

declare(strict_types=1);

namespace App\Blog\Infrastructure\Persistence\Doctrine\Fixture;

use App\Blog\Domain\Category\ArticleCategory;
use App\Blog\Domain\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Blog\Infrastructure\Persistence\Doctrine\Fixture
 */
final class CategoryFixture extends Fixture
{
    private const array CATEGORIES = [
        'A Week of Boson',
        'Case Studies',
        'Cloud',
        'Community',
        'Conferences',
        'Living on the edge',
        'Releases',
        'Security',
        'Frameworks',
    ];

    public function __construct(
        private readonly ArticleCategorySlugGeneratorInterface $slugGenerator,
    ) {}

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $i => $title) {
            $category = new ArticleCategory(
                title: $title,
                slugGenerator: $this->slugGenerator,
                order: $i,
            );

            $manager->persist($category);
        }

        $manager->flush();
    }
}
