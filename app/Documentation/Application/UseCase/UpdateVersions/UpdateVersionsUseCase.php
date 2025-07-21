<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateVersionsUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private VersionsChangeSetComputer $versionsChangeSetComputer,
        private EntityManagerInterface $em,
        private EventBusInterface $events,
    ) {}

    public function __invoke(UpdateVersionsCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    /**
     * @return list<VersionInfo>
     */
    private function getExternalVersionsInfoList(UpdateVersionsCommand $command): array
    {
        $result = [];

        foreach ($command->versions as $index) {
            $result[] = new VersionInfo(
                hash: $index->hash,
                name: $index->name,
            );
        }

        return $result;
    }

    /**
     * @return iterable<array-key, VersionEvent>
     */
    private function process(UpdateVersionsCommand $command): iterable
    {
        $versionsChangePlan = $this->versionsChangeSetComputer->compute(
            $this->versionsListProvider->getAll(hidden: true),
            $this->getExternalVersionsInfoList($command),
        );

        foreach ($versionsChangePlan->updated as $updatedVersion) {
            $this->em->persist($updatedVersion);
        }

        foreach ($versionsChangePlan->created as $createdVersion) {
            $this->em->persist($createdVersion);
        }

        yield from $versionsChangePlan->events;

        $this->em->flush();
    }
}
