<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions;

use App\Documentation\Domain\Version\Event\VersionEvent;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Documentation\Domain\Version\Service\VersionsComputer\ExternalVersionInfo;
use App\Documentation\Domain\Version\Service\VersionsToCreateComputer;
use App\Documentation\Domain\Version\Service\VersionsToUpdateComputer;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateVersionsUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private VersionsToCreateComputer $createdVersionsComputer,
        private VersionsToUpdateComputer $updatedVersionsComputer,
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
     * @return list<ExternalVersionInfo>
     */
    private function getExternalVersionsInfoList(UpdateVersionsCommand $command): array
    {
        $result = [];

        foreach ($command->versions as $index) {
            $result[] = new ExternalVersionInfo(
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
        $existing = $this->versionsListProvider->getAll(hidden: true);
        $updated = $this->getExternalVersionsInfoList($command);

        $updatedVersionsResult = $this->updatedVersionsComputer->compute($existing, $updated);

        foreach ($updatedVersionsResult->versions as $updatedVersion) {
            $this->em->persist($updatedVersion);
        }

        yield from $updatedVersionsResult->events;

        $createdVersionsResult = $this->createdVersionsComputer->compute($existing, $updated);

        foreach ($createdVersionsResult->versions as $createdVersion) {
            $this->em->persist($createdVersion);
        }

        yield from $createdVersionsResult->events;

        $this->em->flush();
    }
}
