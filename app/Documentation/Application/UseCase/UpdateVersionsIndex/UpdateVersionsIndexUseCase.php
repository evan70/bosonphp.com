<?php

declare(strict_types=1);

namespace App\Documentation\Application\UseCase\UpdateVersionsIndex;

use App\Documentation\Application\UseCase\UpdateVersionsIndex\UpdateVersionsIndexCommand\VersionIndex;
use App\Documentation\Domain\Version\Repository\VersionsListProviderInterface;
use App\Documentation\Domain\Version\Version;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(bus: 'command.bus')]
final readonly class UpdateVersionsIndexUseCase
{
    public function __construct(
        private VersionsListProviderInterface $versionsListProvider,
        private EntityManagerInterface $em,
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
        $actualVersions = $this->versionsListProvider->getAll();
        $commandVersionNames = $this->getCommandVersionNames($command->versions);

        foreach ($actualVersions as $actualVersion) {
            // In case of version is present in command
            $isPresent = \in_array($actualVersion->name, $commandVersionNames, true);

            // Enable previously hidden existent version
            // In case of version is not HIDDEN,
            if ($isPresent && $actualVersion->isHidden) {
                $actualVersion->enable();
            }

            // Disable non-existent version
            if (!$isPresent) {
                $actualVersion->disable();
            }
        }

        $actualVersionNames = $this->getActualVersionNames($actualVersions);

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
        }

        $this->em->flush();
    }
}
