<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateCategories;

use App\Documentation\Domain\Category\Event\CategoryEvent;
use App\Documentation\Domain\Category\Service\CategoriesChangeSetComputer;
use App\Documentation\Domain\Category\Service\CategoryInfo;
use App\Documentation\Domain\Version\Repository\VersionByNameProviderInterface;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateCategoriesUseCase
{
    public function __construct(
        private VersionByNameProviderInterface $versionByNameProvider,
        private CategoriesChangeSetComputer $categoriesChangeSetComputer,
        private EntityManagerInterface $em,
        private EventBusInterface $events,
    ) {}

    public function __invoke(UpdateCategoriesCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    /**
     * @return list<CategoryInfo>
     */
    private function getExternalCategoriesInfoList(UpdateCategoriesCommand $command): array
    {
        $result = [];

        foreach ($command->categories as $index) {
            $result[] = new CategoryInfo(
                hash: $index->hash,
                name: $index->name,
                description: $index->description,
                icon: $index->icon,
                order: $index->order,
            );
        }

        return $result;
    }

    /**
     * @return iterable<array-key, CategoryEvent>
     */
    public function process(UpdateCategoriesCommand $command): iterable
    {
        $version = $this->versionByNameProvider->findVersionByName($command->version);

        if ($version === null) {
            // TODO: TBD Version Not Found exception should be thrown?
            return [];
        }

        $categoriesChangeSetPlan = $this->categoriesChangeSetComputer->compute(
            version: $version,
            updated: $this->getExternalCategoriesInfoList($command),
        );

        foreach ($categoriesChangeSetPlan->updated as $updatedCategory) {
            $this->em->persist($updatedCategory);
        }

        foreach ($categoriesChangeSetPlan->created as $createdCategory) {
            $this->em->persist($createdCategory);
        }

        foreach ($categoriesChangeSetPlan->removed as $removedCategory) {
            $this->em->remove($removedCategory);
        }

        yield from $categoriesChangeSetPlan->events;

        $this->em->flush();
    }
}
