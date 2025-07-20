<?php

declare(strict_types=1);

namespace App\Tests\Behat\Extension;

use App\Tests\Behat\Extension\ContextArgumentTransformerExtension\PlaceholderArgumentTransformer;
use Behat\Behat\Transformation\ServiceContainer\TransformationExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @api
 */
final class ContextArgumentTransformerExtension implements Extension
{
    public function process(ContainerBuilder $container): void
    {
        // TODO: Implement process() method.
    }

    public function getConfigKey(): string
    {
        return 'context_argument_transformer';
    }

    public function initialize(ExtensionManager $extensionManager): void
    {
        // TODO: Implement initialize() method.
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('capture')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('start')
                            ->defaultValue('{{')
                        ->end()
                        ->scalarNode('end')
                            ->defaultValue('}}')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function load(ContainerBuilder $container, array $config): void
    {
        $container->register(PlaceholderArgumentTransformer::class, PlaceholderArgumentTransformer::class)
            ->setArgument('$startsAt', $config['capture']['start'] ?? '{{')
            ->setArgument('$endsWith', $config['capture']['end'] ?? '}}')
            ->addTag(TransformationExtension::ARGUMENT_TRANSFORMER_TAG, ['priority' => 1000]);
    }
}
