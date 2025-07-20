<?php

declare(strict_types=1);

namespace App\Tests\Extension\ContextArgumentTransformerExtension;

use Behat\Behat\Context\Context;
use FriendsOfBehat\SymfonyExtension\Context\Environment\InitializedSymfonyExtensionEnvironment;

/**
 * @internal this is an internal library class, please do not use it in your code
 * @psalm-internal App\Tests\Extension
 *
 * @template-extends \ArrayIterator<non-empty-string, Context>
 */
final class ContextSet extends \ArrayIterator
{
    public static function fromEnvironment(InitializedSymfonyExtensionEnvironment $env): self
    {
        $result = [];

        foreach ($env->getContextClasses() as $class) {
            $context = $env->getContext($class);

            $result[self::getContextName($context)] = $context;
        }

        return new self($result);
    }

    /**
     * @return non-empty-string
     */
    private static function getContextName(Context $context): string
    {
        $attributes = new \ReflectionObject($context)
            ->getAttributes(AsTestingContext::class);

        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();

            return $instance->name;
        }

        return $context::class;
    }

    public function __get(string $property): mixed
    {
        return $this->offsetGet($property);
    }

    public function __isset(string $property): bool
    {
        return $this->offsetExists($property);
    }
}
