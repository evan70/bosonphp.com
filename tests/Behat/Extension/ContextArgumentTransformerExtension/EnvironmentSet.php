<?php

declare(strict_types=1);

namespace App\Tests\Behat\Extension\ContextArgumentTransformerExtension;

use FriendsOfBehat\SymfonyExtension\Context\Environment\InitializedSymfonyExtensionEnvironment;

/**
 * @api
 *
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Tests\Behat\Extension
 */
final readonly class EnvironmentSet
{
    /**
     * @var \WeakMap<InitializedSymfonyExtensionEnvironment, ContextSet>
     */
    private \WeakMap $contexts;

    public function __construct()
    {
        $this->contexts = new \WeakMap();
    }

    public function get(InitializedSymfonyExtensionEnvironment $env): ContextSet
    {
        return $this->contexts[$env] ??= ContextSet::fromEnvironment($env);
    }
}
