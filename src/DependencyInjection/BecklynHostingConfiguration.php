<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


class BecklynHostingConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder ()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root("becklyn_monitoring")
            ->children()
                ->scalarNode("tier")
                    ->isRequired()
                    ->info("The deployment environment (or tier) where this app is installed. E.g. 'staging' or 'production'.")
                ->end()
            ->end();

        return $treeBuilder;
    }
}
