<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersions;

use App\Documentation\Application\UseCase\UpdateVersions\Event\UpdateVersionEvent;
use App\Documentation\Application\UseCase\UpdateVersions\Event\VersionCreated;
use App\Documentation\Application\UseCase\UpdateVersions\Event\VersionDisabled;
use App\Documentation\Application\UseCase\UpdateVersions\Event\VersionEnabled;
use App\Documentation\Application\UseCase\UpdateVersions\Event\VersionUpdated;
use App\Documentation\Application\UseCase\UpdateVersions\UpdateVersionsCommand\VersionIndex;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\EventBusInterface;
use App\Shared\Domain\Bus\EventId;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateVersionsUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private EntityManagerInterface $em,
        private EventBusInterface $events,
    ) {}

    /**
     * @param iterable<mixed, VersionIndex> $versions
     *
     * @return array<non-empty-string, VersionIndex>
     */
    private function getCommandVersionsGroupByName(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $version) {
            $result[$version->name] = $version;
        }

        return $result;
    }

    /**
     * @param iterable<mixed, Version> $versions
     *
     * @return list<non-empty-string>
     */
    private function getActualVersionNames(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $version) {
            $result[] = $version->name;
        }

        return $result;
    }

    public function __invoke(UpdateVersionsCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    /**
     * @return iterable<array-key, UpdateVersionEvent>
     */
    private function process(UpdateVersionsCommand $command): iterable
    {
        $databaseVersions = $this->versionsListProvider->getAll();
        $commandVersionsByName = $this->getCommandVersionsGroupByName($command->versions);

        foreach ($databaseVersions as $databaseVersion) {
            // In case of version is present in command
            $commandVersion = $commandVersionsByName[$databaseVersion->name] ?? null;

            // Enable previously hidden existent version
            // In case of version is not HIDDEN,
            if ($commandVersion !== null) {
                // Skip in case hash is equals to stored one
                if ($databaseVersion->hash === $commandVersion->hash) {
                    continue;
                }

                $databaseVersion->hash = $commandVersion->hash;

                if ($databaseVersion->isHidden) {
                    $databaseVersion->enable();

                    yield new VersionEnabled($databaseVersion->name);
                }

                $this->em->persist($databaseVersion);
                yield new VersionUpdated(
                    name: $databaseVersion->name,
                    id: EventId::createFrom($command->id),
                );
            }

            // Disable non-existent version
            if ($commandVersion === null) {
                $databaseVersion->disable();

                yield new VersionDisabled(
                    name: $databaseVersion->name,
                    id: EventId::createFrom($command->id),
                );
            }
        }

        $actualVersionNames = $this->getActualVersionNames($databaseVersions);

        foreach ($command->versions as $commandVersion) {
            // In case of version is present in database
            $isPresent = \in_array($commandVersion->name, $actualVersionNames, true);

            // Skip this case
            if ($isPresent) {
                continue;
            }

            // TODO Should be moved to domain service?
            $this->em->persist(new Version(
                name: $commandVersion->name,
                hash: $commandVersion->hash,
            ));

            yield new VersionCreated(
                name: $commandVersion->name,
                id: EventId::createFrom($command->id),
            );
        }

        $this->em->flush();
    }
}
