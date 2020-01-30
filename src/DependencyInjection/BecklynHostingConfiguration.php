<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection;

use Becklyn\Hosting\Config\HostingConfig;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BecklynHostingConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder ()
    {
        $treeBuilder = new TreeBuilder("becklyn_hosting");

        $treeBuilder->getRootNode()
            ->children()
                ->enumNode("tier")
                    ->isRequired()
                    ->values(HostingConfig::ALLOWED_TIERS)
                    ->info("The deployment environment (or tier) where this app is installed. E.g. 'development', 'staging' or 'production'.")
                ->end()
                ->scalarNode("project")
                    ->isRequired()
                    ->info("The name of the for this project installation. Used for displaying the plain text project name.")
                ->end()
                ->scalarNode("installation")
                    ->isRequired()
                    ->info("An unique identifier for this project installation. Used for identifying it in sentry and uptime monitoring.")
                    ->validate()
                        ->ifTrue(function ($value) { return \preg_match('~[^a-z0-9\\-_]~', $value); })
                        ->thenInvalid("You may only use a-z, '-' and '_' as project key, but '%s' used")
                    ->end()
                ->end()
                ->scalarNode("trackjs")
                    ->defaultNull()
                    ->info("The token for the TrackJS integration.")
                ->end()
            ->end();

        return $treeBuilder;
    }
}
