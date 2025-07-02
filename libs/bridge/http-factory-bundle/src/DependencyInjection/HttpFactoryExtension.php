<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory\DependencyInjection;

use Local\Bridge\HttpFactory\Listener\ControllerRequestDecoderListener;
use Local\Bridge\HttpFactory\Listener\ControllerResultEncoderListener;
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
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Yaml\Yaml;

final class HttpFactoryExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->registerBuiltinDrivers($container);
        $this->registerFactories($container);

        $container->register(ControllerResultEncoderListener::class, ControllerResultEncoderListener::class)
            ->setArgument('$factory', new Reference(ResponseEncoderFactoryInterface::class))
            ->setArgument('$default', new Reference(JsonDriver::class))
            ->addTag('kernel.event_listener', [
                'event' => 'kernel.view',
                'method' => '__invoke',
                'priority' => -32,
            ]);

        $container->register(ControllerRequestDecoderListener::class, ControllerRequestDecoderListener::class)
            ->setArgument('$factory', new Reference(RequestDecoderFactoryInterface::class))
            ->setArgument('$default', new Reference(JsonDriver::class))
            ->addTag('kernel.event_listener', [
                'event' => 'kernel.request',
                'method' => '__invoke',
                'priority' => 32,
            ]);
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

    private function registerFactories(ContainerBuilder $container): void
    {
        $container->register(RequestDecoderFactoryInterface::class, RequestDecoderFactory::class)
            ->setArgument('$decoders', new AutowireIterator('app.request.decoder'));

        $container->register(ResponseEncoderFactoryInterface::class, ResponseEncoderFactory::class)
            ->setArgument('$encoders', new AutowireIterator('app.response.encoder'));
    }
}
