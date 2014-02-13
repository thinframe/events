<?php

/**
 * src/DependencyInjection/EventsConfiguration.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Events\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class EventsConfiguration
 *
 * @package ThinFrame\Events\DependencyInjection
 * @since   0.3
 */
class EventsConfiguration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('events');


        $rootNode
            ->children()
            ->scalarNode('dispatcher_service')->defaultValue('events.dispatcher')->end()
            ->scalarNode('listener_tag')->defaultValue('events.listener')->end()
            ->end();

        return $treeBuilder;
    }
}
