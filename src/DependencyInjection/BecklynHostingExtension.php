<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection;

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\DependencyInjection\CompilerPass\ConfigureSentryPass;
use Sentry\Options;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BecklynHostingExtension extends Extension
{
    /** @var ConfigureSentryPass */
    private $configureSentryPass;


    public function __construct (ConfigureSentryPass $releaseVersionPass)
    {
        $this->configureSentryPass = $releaseVersionPass;
    }

    /**
     * @inheritdoc
     */
    public function load (array $configs, ContainerBuilder $container) : void
    {
        // load services
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . "/../../config")
        );
        $loader->load("services.yaml");

        // parse and pass config
        $config = $this->processConfiguration(new BecklynHostingConfiguration(), $configs);
        $container->getDefinition(HostingConfig::class)
            ->setArgument('$config', $config);

        // set release version here, as we need the project name
        $this->configureSentryPass->setConfig($config["installation_key"], $config["tier"]);
    }


    /**
     * @inheritDoc
     */
    public function prepend (ContainerBuilder $container) : void
    {
        // add sane defaults for the sentry configuration
        $container->prependExtensionConfig('sentry', [
            "options" => [
                "curl_method" => "async",
                "project_root" => $container->getParameter("kernel.project_dir"),
                "send_default_pii" => false,
                "excluded_exceptions" => [
                    AccessDeniedHttpException::class,
                    NotFoundHttpException::class,
                ],
            ],
        ]);
    }
}
