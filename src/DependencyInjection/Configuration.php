<?php declare(strict_types=1);

namespace ju1ius\XdgMimeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $tree = new TreeBuilder('ju1ius_xdg_mime');
        $tree->getRootNode()
            ->children()
                ->scalarNode('cache_prefix')
                    ->info('Cache prefix.')
                    ->cannotBeEmpty()
                    ->defaultValue('xdg-mime')
                    ->treatNullLike('xdg-mime')
                ->end()
                ->arrayNode('custom_database')
                    ->info('Use a custom XDG mime database instead of the built-in default.')
                    ->canBeEnabled()
                    ->fixXmlConfig('path')
                    ->children()
                        ->booleanNode('use_xdg_directories')
                            ->info('Adds mime-info XML files from the standard XDG data directories.')
                            ->defaultTrue()
                        ->end()
                        ->arrayNode('paths')
                            ->info('Adds custom mime-info files or directories.')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                    ->validate()
                        ->ifTrue(fn($v) => $v['enabled'] && !$v['use_xdg_directories'] && !$v['paths'])
                        ->thenInvalid('You must provide custom paths when not using standard XDG directories.')
                    ->end()
                ->end()
            ->end()
        ;

        return $tree;
    }
}
