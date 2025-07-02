<?php

declare(strict_types=1);

namespace Local\Bridge\HttpFactory;

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
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\Yaml\Yaml;

final class HttpFactoryBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        $this->registerBuiltinDrivers($container);
        $this->registerFactories($container);
    }

    private function registerBuiltinDrivers(ContainerBuilder $container): void
    {
        if (\class_exists(MessagePack::class)) {
            $container->register(MessagePackDriver::class)
                ->addTag('bsg.request.decoder')
                ->addTag('bsg.response.encoder');
        }

        if (\class_exists(Yaml::class)) {
            $container->register(YamlDriver::class)
                ->addTag('bsg.request.decoder')
                ->addTag('bsg.response.encoder');
        }

        $container->register(JsonDriver::class)
            ->setArgument('$debug', '%kernel.debug%')
            ->addTag('bsg.request.decoder')
            ->addTag('bsg.response.encoder');
    }

    private function registerFactories(ContainerBuilder $container): void
    {
        $container->register(RequestDecoderFactoryInterface::class, RequestDecoderFactory::class)
            ->setArgument('$decoders', new AutowireIterator('bsg.request.decoder'));

        $container->register(ResponseEncoderFactoryInterface::class, ResponseEncoderFactory::class)
            ->setArgument('$encoders', new AutowireIterator('bsg.response.encoder'));
    }
}
