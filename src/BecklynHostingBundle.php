<?php declare(strict_types=1);

namespace Becklyn\Hosting;

use Becklyn\AssetsBundle\Namespaces\RegisterAssetNamespacesCompilerPass;
use Becklyn\Hosting\DependencyInjection\BecklynHostingExtension;
use Becklyn\Hosting\DependencyInjection\CompilerPass\ConfigureSentryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BecklynHostingBundle extends Bundle
{
    private ConfigureSentryPass $releaseVersionPass;


    public function __construct ()
    {
        $this->releaseVersionPass = new ConfigureSentryPass();
    }


    /**
     * @inheritDoc
     */
    public function build (ContainerBuilder $container) : void
    {
        $container->addCompilerPass(
            new RegisterAssetNamespacesCompilerPass([
                "hosting" => __DIR__ . "/../build",
            ])
        );

        $container->addCompilerPass($this->releaseVersionPass);
    }


    /**
     * @inheritDoc
     */
    public function getContainerExtension ()
    {
        return new BecklynHostingExtension($this->releaseVersionPass);
    }


    /**
     * @inheritDoc
     */
    public function getPath () : string
    {
        return \dirname(__DIR__);
    }
}
