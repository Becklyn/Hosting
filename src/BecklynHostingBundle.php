<?php declare(strict_types=1);

namespace Becklyn\Hosting;

use Becklyn\AssetsBundle\Namespaces\RegisterAssetNamespacesCompilerPass;
use Becklyn\Hosting\DependencyInjection\BecklynHostingExtension;
use Becklyn\Hosting\DependencyInjection\CompilerPass\ReleaseVersionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class BecklynHostingBundle extends Bundle
{
    /**
     * @var ReleaseVersionPass
     */
    private $releaseVersionPass;


    /**
     *
     */
    public function __construct ()
    {
        $this->releaseVersionPass = new ReleaseVersionPass();
    }


    /**
     * @inheritDoc
     */
    public function build (ContainerBuilder $container) : void
    {
        if (\class_exists(RegisterAssetNamespacesCompilerPass::class))
        {
            $container->addCompilerPass(
                new RegisterAssetNamespacesCompilerPass([
                    "hosting" => __DIR__ . "/../src/Resources/public",
                ])
            );

        }

        $container->addCompilerPass($this->releaseVersionPass);
    }


    /**
     * @inheritDoc
     */
    public function getContainerExtension ()
    {
        return new BecklynHostingExtension($this->releaseVersionPass);
    }
}
