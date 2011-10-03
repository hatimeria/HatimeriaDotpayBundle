<?php

namespace Hatimeria\DotpayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hatimeria_dotpay');

        $rootNode
            ->children()
                ->booleanNode('test_mode')->defaultTrue()->end()
                ->scalarNode('id')->cannotBeOverwritten()->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('pin')->defaultNull()->cannotBeEmpty()->end()
                ->scalarNode('secure_url')->defaultValue('https://ssl.dotpay.pl/')->end()
                ->scalarNode('ip')->defaultValue('195.150.9.37')->end()
                ->arrayNode('request')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('submit_idle')->defaultValue(1000)->end()
                        ->scalarNode('urlc')->defaultValue('hatimeria_dotpay_response')->end()
                        ->scalarNode('url')->defaultNull()->end()
                        ->scalarNode('type')->defaultNull()->end()
                        ->scalarNode('buttontext')->defaultNull()->end()
                        ->scalarNode('description')->defaultValue('TEST TRANSACTION')->end()
                        ->scalarNode('currency')->defaultNull()->end()
                        ->scalarNode('lang')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('response')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('manager')->defaultValue('Hatimeria\DotpayBundle\Manager\ResponseManager')->end()
                    ->end()
                ->end()
                ->arrayNode('premium_tc')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('manager')->defaultValue('Hatimeria\DotpayBundle\Manager\PremiumTcManager')->end()
                    ->end()
                ->end()
                ->arrayNode('forms')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('request')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('Hatimeria\DotpayBundle\Form\Type\RequestFormType')->end()
                                ->scalarNode('data_class')->defaultValue('Hatimeria\DotpayBundle\Request\Request')->end()
                                ->scalarNode('handler')->defaultValue('Hatimeria\DotpayBundle\Form\Handler\RequestFormHandler')->end()
                            ->end()
                        ->end()
                        ->arrayNode('response')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('Hatimeria\DotpayBundle\Form\Type\ResponseFormType')->end()
                                ->scalarNode('data_class')->defaultValue('Hatimeria\DotpayBundle\Response\Response')->end()
                                ->scalarNode('handler')->defaultValue('Hatimeria\DotpayBundle\Form\Handler\ResponseFormHandler')->end()
                            ->end()
                        ->end()
                        ->arrayNode('premium_tc')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('Hatimeria\DotpayBundle\Form\Type\PremiumTcFormType')->end()
                                ->scalarNode('data_class')->defaultValue('Hatimeria\DotpayBundle\Request\PremiumTc')->end()
                                ->scalarNode('handler')->defaultValue('Hatimeria\DotpayBundle\Form\Handler\ResponseFormHandler')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
    
}
