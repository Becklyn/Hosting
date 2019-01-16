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

        $treeBuilder->root("becklyn_hosting")
            ->children()
                ->scalarNode("tier")
                    ->isRequired()
                    ->info("The deployment environment (or tier) where this app is installed. E.g. 'staging' or 'production'.")
                ->end()
                ->scalarNode("project_name")
                    ->isRequired()
                    ->info("An unique identifier for this project installation. Used for identifying it in sentry and uptime monitoring.")
                ->end()
                ->scalarNode("trackjs")
                    ->defaultNull()
                    ->info("The token for the TrackJS integration.")
                ->end()
            ->end();

        return $treeBuilder;
    }
}
