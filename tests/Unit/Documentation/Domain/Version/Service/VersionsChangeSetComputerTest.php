<?php

declare(strict_types=1);

namespace App\Tests\Unit\Documentation\Domain\Version\Service;

use App\Documentation\Domain\Version\Event\VersionCreated;
use App\Documentation\Domain\Version\Event\VersionUpdated;
use App\Documentation\Domain\Version\Service\VersionInfo;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToCreateComputer;
use App\Documentation\Domain\Version\Service\VersionsChangeSetComputer\VersionsToUpdateComputer;
use App\Documentation\Domain\Version\Version;
use App\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(VersionsChangeSetComputer::class)]
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

    public function testEmptyInput(): void
    {
        $plan = $this->computer->compute([], []);

        self::assertCount(0, $plan->created);
        self::assertCount(0, $plan->updated);
        self::assertCount(0, $plan->events);
    }

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
}
