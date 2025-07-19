<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory\DependencyInjection;

use Local\Component\HttpFactory\Driver\JsonDriver;
use Local\Component\HttpFactory\Driver\MessagePackDriver;
use Local\Component\HttpFactory\Driver\YamlDriver;
use Local\Component\HttpFactory\RequestDecoderFactory;
use Local\Component\HttpFactory\RequestDecoderFactoryInterface;
use Local\Component\HttpFactory\RequestDecoderInterface;
use Local\Component\HttpFactory\ResponseEncoderFactory;
use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use Local\Component\HttpFactory\ResponseEncoderInterface;
use MessagePack\MessagePack;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Yaml\Yaml;

final class HttpFactoryExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->registerBuiltinDrivers($container);
        $this->registerDefaultDriver($container);
        $this->registerFactories($container);
    }

    private function registerBuiltinDrivers(ContainerBuilder $container): void
    {
        if (\class_exists(MessagePack::class)) {
            $container->register(MessagePackDriver::class)
                ->addTag('phpdoc.request.decoder')
                ->addTag('phpdoc.response.encoder');
        }

        if (\class_exists(Yaml::class)) {
            $container->register(YamlDriver::class)
                ->addTag('phpdoc.request.decoder')
                ->addTag('phpdoc.response.encoder');
        }

        $container->register(JsonDriver::class)
            ->setArgument('$debug', '%kernel.debug%')
            ->addTag('phpdoc.request.decoder')
            ->addTag('phpdoc.response.encoder');
    }

    private function registerDefaultDriver(ContainerBuilder $container): void
    {
        $container->setAlias(RequestDecoderInterface::class, JsonDriver::class);
        $container->setAlias(ResponseEncoderInterface::class, JsonDriver::class);
    }

    private function registerFactories(ContainerBuilder $container): void
    {
        $container->register(RequestDecoderFactoryInterface::class, RequestDecoderFactory::class)
            ->setArgument('$decoders', new AutowireIterator('phpdoc.request.decoder'));

        $container->register(ResponseEncoderFactoryInterface::class, ResponseEncoderFactory::class)
            ->setArgument('$encoders', new AutowireIterator('phpdoc.response.encoder'));
    }
}
