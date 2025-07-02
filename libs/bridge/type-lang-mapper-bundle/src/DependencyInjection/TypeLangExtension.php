<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang\DependencyInjection;

use Local\Bridge\TypeLang\TypeLangPlatform;
use Symfony\Component\Cache\Psr16Cache;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use TypeLang\Mapper\DenormalizerInterface;
use TypeLang\Mapper\Mapper;
use TypeLang\Mapper\Mapping\Driver\AttributeDriver;
use TypeLang\Mapper\Mapping\Driver\DocBlockDriver;
use TypeLang\Mapper\Mapping\Driver\DriverInterface;
use TypeLang\Mapper\Mapping\Driver\NullDriver;
use TypeLang\Mapper\Mapping\Driver\Psr16CachedDriver;
use TypeLang\Mapper\Mapping\Driver\ReflectionDriver;
use TypeLang\Mapper\NormalizerInterface;
use TypeLang\Mapper\Platform\PlatformInterface;
use TypeLang\Mapper\Runtime\Configuration;
use TypeLang\Mapper\Runtime\Tracing\SymfonyStopwatchTracer;
use TypeLang\Mapper\Runtime\Tracing\TracerInterface;

final class TypeLangExtension extends Extension
{
    /**
     * @param array<array-key, mixed> $config
     */
    public function getConfiguration(array $config, ContainerBuilder $container): TypeLangConfiguration
    {
        return new TypeLangConfiguration();
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        // Cache
        $container->setAlias('type_lang.cache.psr6', 'cache.app');
        $container->register('type_lang.cache.psr16', Psr16Cache::class)
            ->setArgument('$pool', new Reference('type_lang.cache.psr6'))
        ;

        // Expression Language
        $container->register('type_lang.expression_language', ExpressionLanguage::class)
            ->setArgument('$cache', new Reference('cache.app'))
        ;

        $this->registerDriver($container);
        $this->registerPlatform($container);
        $this->registerConfiguration($container);
        $this->registerMapper($container);
    }

    private function registerDriver(ContainerBuilder $container): void
    {
        $container->register(DriverInterface::class, NullDriver::class);

        $this->registerReflectionDriver($container);
        $this->registerAttributeDriver($container);
        $this->registerDocBlockDriver($container);
        $this->registerCachedDriver($container);
    }

    private function registerDocBlockDriver(ContainerBuilder $container): void
    {
        $container->register('type_lang.driver.docblock', DocBlockDriver::class)
            ->setDecoratedService(DriverInterface::class)
            ->setArgument('$delegate', new Reference('.inner'))
        ;
    }

    private function registerAttributeDriver(ContainerBuilder $container): void
    {
        $container->register('type_lang.driver.attribute', AttributeDriver::class)
            ->setDecoratedService(DriverInterface::class)
            ->setArgument('$delegate', new Reference('.inner'))
            ->setArgument('$expression', new Reference('type_lang.expression_language'))
        ;
    }

    private function registerReflectionDriver(ContainerBuilder $container): void
    {
        $container->register('type_lang.driver.reflection', ReflectionDriver::class)
            ->setDecoratedService(DriverInterface::class)
            ->setArgument('$delegate', new Reference('.inner'))
        ;
    }

    private function registerCachedDriver(ContainerBuilder $container): void
    {
        //if ($container->getParameter('kernel.debug')) {
        //    return;
        //}

        $container->register('type_lang.driver.cached', Psr16CachedDriver::class)
            ->setDecoratedService(DriverInterface::class)
            ->setArgument('$cache', new Reference('type_lang.cache.psr16'))
            ->setArgument('$delegate', new Reference('.inner'))
        ;
    }

    private function registerPlatform(ContainerBuilder $container): void
    {
        $container->register(PlatformInterface::class, TypeLangPlatform::class)
            ->setArgument('$driver', new Reference(DriverInterface::class))
        ;
    }

    private function registerMapper(ContainerBuilder $container): void
    {
        $container->register(Mapper::class, Mapper::class)
            ->setArgument('$platform', new Reference(PlatformInterface::class))
        ;

        $container->setAlias(DenormalizerInterface::class, Mapper::class);
        $container->setAlias(NormalizerInterface::class, Mapper::class);
    }

    private function registerConfiguration(ContainerBuilder $container): void
    {
        $definition = $container->register(Configuration::class, Configuration::class);

        if ($container->getParameter('kernel.debug')) {
            $container->register(TracerInterface::class, SymfonyStopwatchTracer::class)
                ->setArgument('$stopwatch', new Reference('debug.stopwatch'));

            $definition->setArgument('$tracer', new Reference(TracerInterface::class));
        }
    }
}
