<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_cloudflare');

        $rootNode
            ->children()
                ->arrayNode('http')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('client')->defaultValue('httplug.client')->end()
                    ->end()
                ->end()
                ->arrayNode('credentials')
                    ->isRequired()
                    ->children()
                        ->scalarNode('email')->cannotBeEmpty()->end()
                        ->scalarNode('api_key')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
