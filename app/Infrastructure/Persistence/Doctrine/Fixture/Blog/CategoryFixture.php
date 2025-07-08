<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture\Blog;

use App\Domain\Blog\Category\ArticleCategory;
use App\Domain\Blog\Category\ArticleCategorySlugGeneratorInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Infrastructure\Persistence\Doctrine\Fixture
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
