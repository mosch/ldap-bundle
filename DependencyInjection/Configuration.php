<?php

namespace Agixo\LdapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('agixo_ldap');

        $rootNode
            ->children()
            ->arrayNode('driver')
            ->children()
            ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('port')->defaultValue(389)->end()
            ->scalarNode('bindDn')->isRequired()->end()
            ->scalarNode('baseDn')->isRequired()->end()
            ->scalarNode('loginAttribute')->isRequired()->end()
            ->end()
            ->end()
            ->arrayNode('user')
            ->children()
            ->arrayNode('attributes')
            ->prototype('array')
            ->children()
            ->scalarNode('ldap_attr')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('user_method')->isRequired()->cannotBeEmpty()->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();
        ;

        return $treeBuilder;
    }
}
