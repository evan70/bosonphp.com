<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\Event\VersionCreated;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\Event\VersionDisabled;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\Event\VersionEnabled;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\Event\VersionEvent;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\Event\VersionUpdated;
use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\VersionIndex;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Documentation\Domain\Version\Version;
use App\Shared\Domain\Bus\EventBusInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateVersionsIndexUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private EntityManagerInterface $em,
        private EventBusInterface $events,
    ) {}

    /**
     * @param iterable<mixed, VersionIndex> $versions
     * @return list<non-empty-string>
     */
    private function getCommandVersionNames(iterable $versions): array
    {
        $result = [];

        foreach ($versions as $version) {
            $result[] = $version->name;
        }

        return $result;
    }

    /**
     * @param iterable<mixed, Version> $versions
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

    public function __invoke(UpdateVersionsIndexCommand $command): void
    {
        $events = \iterator_to_array($this->process($command));

        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }

    /**
     * @return iterable<array-key, VersionEvent>
     */
    private function process(UpdateVersionsIndexCommand $command): iterable
    {
        $databaseVersions = $this->versionsListProvider->getAll();
        $commandVersionNames = $this->getCommandVersionNames($command->versions);

        foreach ($databaseVersions as $databaseVersion) {
            // In case of version is present in command
            $isPresent = \in_array($databaseVersion->name, $commandVersionNames, true);

            // Enable previously hidden existent version
            // In case of version is not HIDDEN,
            if ($isPresent) {
                if ($databaseVersion->isHidden) {
                    $databaseVersion->enable();

                    yield new VersionEnabled($databaseVersion->name);
                }

                yield new VersionUpdated($databaseVersion->name);
            }

            // Disable non-existent version
            if (!$isPresent) {
                $databaseVersion->disable();

                yield new VersionDisabled($databaseVersion->name);
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
            ));

            yield new VersionCreated($commandVersion->name);
        }

        $this->em->flush();
    }
}
