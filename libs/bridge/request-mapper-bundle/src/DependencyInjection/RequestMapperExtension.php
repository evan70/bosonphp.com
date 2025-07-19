<?php

declare(strict_types=1);

namespace Local\Bridge\RequestMapper\DependencyInjection;

use Local\Bridge\RequestMapper\ValueResolver\MapRequestValueResolver;
use Local\Component\HttpFactory\RequestDecoderFactoryInterface;
use Local\Component\HttpFactory\RequestDecoderInterface;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use TypeLang\Mapper\DenormalizerInterface;

final class RequestMapperExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->register(MapRequestValueResolver::class, MapRequestValueResolver::class)
            ->setArgument('$denormalizer', new Reference(DenormalizerInterface::class))
            ->setArgument('$factory', new Reference(RequestDecoderFactoryInterface::class))
            ->setArgument('$default', new Reference(RequestDecoderInterface::class))
            ->addTag('controller.argument_value_resolver')
        ;
    }
}
