<?php

namespace Borsaco\CoinbaseBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\HttpKernel\Kernel;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        if (Kernel::VERSION_ID >= 40200) {
            $builder = new TreeBuilder('coinbase');
        } else {
            $builder = new TreeBuilder();
        }

        
        $rootNode = \method_exists($builder, 'getRootNode') ? $builder->getRootNode() : $builder->root('coinbase');
        $rootNode
            ->children()
                ->arrayNode('api')
                    ->children()
                        ->scalarNode('key')->end()
                        ->scalarNode('version')->end()
                    ->end()
                ->end()
                ->arrayNode('webhook')
                    ->children()
                        ->scalarNode('secret')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $builder;
    }
}