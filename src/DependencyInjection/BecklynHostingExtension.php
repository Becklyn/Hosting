<?php declare(strict_types=1);

namespace Becklyn\Hosting\DependencyInjection;

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\DependencyInjection\CompilerPass\ConfigureSentryPass;
use Becklyn\Hosting\Sentry\Integration\UserRoleSentryIntegration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class BecklynHostingExtension extends Extension implements PrependExtensionInterface
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
        $this->configureSentryPass->setConfig($config["installation"], $config["tier"]);

        $container->getDefinition("becklyn_hosting_ignored_errors")
            ->setArgument(0, [
                "ignore_exceptions" => [
                    AccessDeniedHttpException::class,
                    AccessDeniedException::class,
                    CommandNotFoundException::class,
                    'Mayd\\Foundation\\Exception\\Request\\RequestMatchException',
                    NotFoundHttpException::class,
                ],
            ]);
    }


    /**
     * @inheritDoc
     */
    public function prepend (ContainerBuilder $container) : void
    {
        $container->prependExtensionConfig("sentry", [
            "options" => [
                "integrations" => [
                    "@becklyn_hosting_ignored_errors",
                    "@" . UserRoleSentryIntegration::class,
                ],
                "in_app_exclude" => [
                    "%kernel.cache_dir%",
                    "%kernel.project_dir%/vendor",
                    "%kernel.project_dir%/vendor-bin",
                ],
                "in_app_include" => [
                    "%kernel.project_dir%/config",
                    "%kernel.project_dir%/src",
                    "%kernel.project_dir%/templates",
                    "%kernel.project_dir%/tests",
                ],
                "send_default_pii" => false,
            ],
        ]);
    }
}
