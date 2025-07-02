<?php

declare(strict_types=1);

namespace Local\Component\Set\Tests;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase as BaseTestCase;

#[Group('component'), Group('local/set-component')]
abstract class TestCase extends BaseTestCase {}
