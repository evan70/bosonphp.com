<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory\DependencyInjection;

use Local\Component\HttpFactory\RequestDecoderInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Local\Component\HttpFactory\Driver\JsonDriver;
use Local\Component\HttpFactory\Driver\MessagePackDriver;
use Local\Component\HttpFactory\Driver\YamlDriver;
use Local\Component\HttpFactory\RequestDecoderFactory;
use Local\Component\HttpFactory\RequestDecoderFactoryInterface;
use Local\Component\HttpFactory\ResponseEncoderFactory;
use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use MessagePack\MessagePack;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
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
                ->addTag('app.request.decoder')
                ->addTag('app.response.encoder');
        }

        if (\class_exists(Yaml::class)) {
            $container->register(YamlDriver::class)
                ->addTag('app.request.decoder')
                ->addTag('app.response.encoder');
        }

        $container->register(JsonDriver::class)
            ->setArgument('$debug', '%kernel.debug%')
            ->addTag('app.request.decoder')
            ->addTag('app.response.encoder');
    }

    private function registerDefaultDriver(ContainerBuilder $container): void
    {
        $container->setAlias(RequestDecoderInterface::class, JsonDriver::class);
    }

    private function registerFactories(ContainerBuilder $container): void
    {
        $container->register(RequestDecoderFactoryInterface::class, RequestDecoderFactory::class)
            ->setArgument('$decoders', new AutowireIterator('app.request.decoder'));

        $container->register(ResponseEncoderFactoryInterface::class, ResponseEncoderFactory::class)
            ->setArgument('$encoders', new AutowireIterator('app.response.encoder'));
    }
}
