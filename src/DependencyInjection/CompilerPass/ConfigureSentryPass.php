<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection\CompilerPass;

use Becklyn\Hosting\Git\GitIntegration;
use Sentry\Options;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigureSentryPass implements CompilerPassInterface
{
    private ?string $projectInstallationKey = null;
    private ?string $tier = null;


    public function setConfig (string $projectInstallationKey, string $tier) : void
    {
        $this->projectInstallationKey = $projectInstallationKey;
        $this->tier = $tier;
    }


    /**
     * @inheritDoc
     */
    public function process (ContainerBuilder $container) : void
    {
        $git = new GitIntegration($container->getParameter("kernel.project_dir"));
        $version = $git->fetchHeadCommitHash() ?? "?";

        $container->getDefinition(Options::class)
            ->addMethodCall("setEnvironment", [$this->tier])
            ->addMethodCall("setRelease", ["{$this->projectInstallationKey}@{$version}"]);
    }
}
