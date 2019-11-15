<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection\CompilerPass;

use Becklyn\Hosting\Git\GitIntegration;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReleaseVersionPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $projectName;


    /**
     */
    public function setProjectName (string $projectName) : void
    {
        $this->projectName = $projectName;
    }



    /**
     * @inheritDoc
     */
    public function process (ContainerBuilder $container) : void
    {
        if (!$container->hasDefinition("sentry.client"))
        {
            return;
        }

        $git = new GitIntegration($container->getParameter('kernel.project_dir'));
        $version = $git->fetchHeadCommitHash() ?? "?";

        $container->getDefinition("sentry.client")
            ->addMethodCall("setRelease", ["{$this->projectName}@{$version}"]);
    }
}
