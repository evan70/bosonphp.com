<?php

declare(strict_types=1);

namespace Local\Bridge\TypeLang\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class TypeLangConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder('type_lang');

        $root = $tree->getRootNode();

        /** @phpstan-ignore-next-line : Known non-fixable issue */
        $root->children()
        ->end();

        return $tree;
    }
}
