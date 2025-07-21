<?php

declare(strict_types=1);

namespace App\Tests\Unit\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionCreated;
use App\Documentation\Domain\Version\Event\VersionDisabled;
use App\Documentation\Domain\Version\Event\VersionEnabled;
use App\Documentation\Domain\Version\Event\VersionUpdated;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToCreateComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToUpdateComputer;
use App\Documentation\Domain\Version\Version;
use App\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\TestDox;

final class VersionsChangeSetComputerTest extends TestCase
{
    private VersionsChangeSetComputer $computer;

    protected function setUp(): void
    {
        $this->computer = new VersionsChangeSetComputer(
            new VersionsToUpdateComputer(),
            new VersionsToCreateComputer(),
        );
    }

    #[TestDox('No changes if all versions match by name and hash')]
    public function testNoChanges(): void
    {
        $plan = $this->computer->compute([
            new Version('v1.0', hash: 'hash1'),
        ], [
            new VersionInfo(hash: 'hash1', name: 'v1.0'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Creates version if it does not exist')]
    public function testOnlyCreate(): void
    {
        $plan = $this->computer->compute([], [
            new VersionInfo(hash: 'hash1', name: 'v1.0'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('v1.0', $plan->created[0]->name);
        self::assertCount(0, $plan->updated);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(VersionCreated::class, $plan->events[0]);
    }

    #[TestDox('Updates version if hash changes')]
    public function testOnlyUpdate(): void
    {
        $plan = $this->computer->compute([
            new Version('v1.0', hash: 'oldhash'),
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('v1.0', $plan->updated[0]->name);
        self::assertSame('newhash', $plan->updated[0]->hash);
        self::assertCount(1, $plan->events);
        self::assertInstanceOf(VersionUpdated::class, $plan->events[0]);
    }

    #[TestDox('Creates and updates versions simultaneously')]
    public function testCreateAndUpdate(): void
    {
        $plan = $this->computer->compute([
            new Version('v1.0', hash: 'oldhash'),
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
            new VersionInfo(hash: 'hash2', name: 'v2.0'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('v2.0', $plan->created[0]->name);
        self::assertCount(1, $plan->updated);
        self::assertSame('v1.0', $plan->updated[0]->name);
        self::assertCount(2, $plan->events);
    }

    #[TestDox('No changes for empty input')]
    public function testEmptyInput(): void
    {
        $plan = $this->computer->compute([], []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Handles duplicate version names in input and existing')]
    public function testDuplicateNames(): void
    {
        $plan = $this->computer->compute([
            new Version('v1.0', hash: 'oldhash'),
            new Version('v1.0', hash: 'oldhash'),
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
            new VersionInfo(hash: 'hash2', name: 'v2.0'),
            new VersionInfo(hash: 'hash2', name: 'v2.0'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertSame('v2.0', $plan->created[0]->name);
        self::assertSame('v1.0', $plan->updated[0]->name);
    }

    #[TestDox('Order of input does not affect result')]
    public function testOrderOfInputDoesNotAffectResult(): void
    {
        $plan1 = $this->computer->compute([
            new Version('v1.0', hash: 'oldhash'),
            new Version('v2.0', hash: 'oldhash2'),
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
            new VersionInfo(hash: 'hash2', name: 'v2.0'),
        ]);

        $plan2 = $this->computer->compute([
            new Version('v2.0', hash: 'oldhash2'),
            new Version('v1.0', hash: 'oldhash'),
        ], [
            new VersionInfo(hash: 'hash2', name: 'v2.0'),
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
        ]);

        $names1 = [$plan1->updated[0]->name, $plan1->created[0]->name];
        $names2 = [$plan2->updated[0]->name, $plan2->created[0]->name];

        sort($names1);
        sort($names2);

        self::assertSame($names1, $names2);
    }

    #[TestDox('Disables version if missing in input')]
    public function testDisableVersionIfMissingInInput(): void
    {
        $version = new Version('v1.0', hash: 'hash1');

        $plan = $this->computer->compute([
            $version,
        ], []);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertCount(2, $plan->events);
        self::assertInstanceOf(VersionDisabled::class, $plan->events[0]);
        self::assertInstanceOf(VersionUpdated::class, $plan->events[1]);
        self::assertTrue($version->isHidden);
    }

    #[TestDox('No disable if version already hidden')]
    public function testNoDisableIfAlreadyHidden(): void
    {
        $version = new Version('v1.0', hash: 'hash1');
        $version->disable();

        $plan = $this->computer->compute([$version], []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

    #[TestDox('Enables hidden version if present in input')]
    public function testEnableHiddenVersionIfPresentInInput(): void
    {
        $version = new Version('v1.0', hash: 'oldhash');
        $version->disable();

        $plan = $this->computer->compute([
            $version,
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
        ]);

        self::assertCount(0, $plan->created);
        self::assertCount(1, $plan->updated);
        self::assertFalse($version->isHidden);
        self::assertTrue($plan->events[0] instanceof VersionEnabled);
        self::assertTrue($plan->events[1] instanceof VersionUpdated);
    }

    #[TestDox('Updates hash and enables hidden version')]
    public function testUpdateHashOfHiddenVersionEnablesIt(): void
    {
        $version = new Version('v1.0', hash: 'oldhash');
        $version->disable();

        $plan = $this->computer->compute([
            $version,
        ], [
            new VersionInfo(hash: 'newhash', name: 'v1.0'),
        ]);

        self::assertFalse($version->isHidden);
        self::assertSame('newhash', $version->hash);
        self::assertCount(1, $plan->updated);
        self::assertTrue($plan->events[0] instanceof VersionEnabled);
        self::assertTrue($plan->events[1] instanceof VersionUpdated);
    }

    #[TestDox('Handles duplicate names with different hash in input')]
    public function testDuplicateNamesWithDifferentHash(): void
    {
        $plan = $this->computer->compute([], [
            new VersionInfo(hash: 'hash1', name: 'v1.0'),
            new VersionInfo(hash: 'hash2', name: 'v1.0'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('v1.0', $plan->created[0]->name);
    }

    #[TestDox('Handles duplicate names in input without existing versions')]
    public function testDuplicateNamesInInputWithoutExisting(): void
    {
        $plan = $this->computer->compute([], [
            new VersionInfo(hash: 'hash1', name: 'v1.0'),
            new VersionInfo(hash: 'hash1', name: 'v1.0'),
        ]);

        self::assertCount(1, $plan->created);
        self::assertSame('v1.0', $plan->created[0]->name);
    }
}
