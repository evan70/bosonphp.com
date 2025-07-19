<?php

declare(strict_types=1);

namespace Local\Bridge\ResponseMapper\DependencyInjection;

use Local\Bridge\ResponseMapper\Listener\FailureResponseListener;
use Local\Bridge\ResponseMapper\Listener\SuccessfulResponseListener;
use Local\Component\HttpFactory\ResponseEncoderFactoryInterface;
use Local\Component\HttpFactory\ResponseEncoderInterface;
use Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

final class ResponseMapperExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $mappers = new ServiceLocatorArgument(
            values: new TaggedIteratorArgument(
                tag: 'phpdoc.response_mapper',
                indexAttribute: 'name',
                needsIndexes: true,
            ),
        );

        $container->register(SuccessfulResponseListener::class, SuccessfulResponseListener::class)
            ->setArgument('$factory', new Reference(ResponseEncoderFactoryInterface::class))
            ->setArgument('$default', new Reference(ResponseEncoderInterface::class))
            ->setArgument('$mappers', $mappers)
            ->addTag('kernel.event_listener', ['priority' => 64]);

        $container->register(FailureResponseListener::class, FailureResponseListener::class)
            ->setArgument('$factory', new Reference(ResponseEncoderFactoryInterface::class))
            ->setArgument('$default', new Reference(ResponseEncoderInterface::class))
            ->setArgument('$mappers', $mappers)
            ->addTag('kernel.event_listener', ['priority' => 64]);
    }
}
