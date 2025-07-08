<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Fixture\Documentation;

use App\Domain\Documentation\Category\Category;
use App\Domain\Documentation\Version\Version;
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
final class CategoryFixture extends Fixture implements DependentFixtureInterface
{
    private const array CATEGORIES = [
        'Overview',
        'Getting Started',
        'The Basics',
        'Application APIs',
        'WebView APIs',
        'Distribute',
        'Components',
        'Framework Integrations',
        'Examples',
        'Contribution Guide',
        'License',
    ];

    private const array ICONS = [
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/moveToRightBottom_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/moveToRightTop_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/newFolder_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/playBack_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/playFirst_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/playForward_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/playLast_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/preview_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/profileCPU_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/profileMemory_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/profileRed_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/projectDirectory_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/reformatCode_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/replace_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/report_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/rerunAutomatically_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/restartStop_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/runAll_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/selectAll_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/shortcutFilter_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/showImportStatements_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/showReadAccess_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/showWriteAccess_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/split_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/startMemoryProfile_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/suggestedRefactoringBulb_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/swapPanels_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/synchronizeScrolling_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/toggleVisibility_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/undeploy_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/unselectAll_dark.svg',
        'https://intellij-icons.jetbrains.design/icons/AllIcons/expui/actions/addFile_dark.svg',
    ];

    public function __construct(
        private readonly Generator $faker,
    ) {}

    public function load(ObjectManager $manager): void
    {
        $versions = $manager->getRepository(Version::class)
            ->findBy([], ['name' => 'ASC']); // Reverse order

        foreach (self::CATEGORIES as $i => $title) {
            foreach ($versions as $version) {
                $description = $this->faker->sentence(
                    $this->faker->numberBetween(3, 10)
                );

                $category = new Category(
                    version: $version,
                    title: $title,
                    description: $this->faker->numberBetween(0, 1) === 0
                        ? \rtrim($description, '.')
                        : null,
                    icon: $this->faker->randomElement(self::ICONS),
                    order: $i,
                );

                $manager->persist($category);
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
            VersionFixture::class,
        ];
    }
}
