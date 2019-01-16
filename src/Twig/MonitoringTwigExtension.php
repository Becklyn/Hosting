<?php declare(strict_types=1);

namespace Becklyn\Hosting\Twig;

use Becklyn\AssetsBundle\Helper\AssetHelper;
use Becklyn\Hosting\Config\HostingConfig;
use Symfony\Component\Asset\Packages;


class MonitoringTwigExtension extends \Twig_Extension
{
    /**
     * @var HostingConfig
     */
    private $hostingConfig;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $isDebug;

    /**
     * @var AssetHelper|null
     */
    private $assetHelper;

    /**
     * @var Packages|null
     */
    private $packages;


    /**
     * @param HostingConfig    $hostingConfig
     * @param AssetHelper|null $assetHelper
     * @param Packages|null    $packages
     * @param string           $environment
     * @param string           $isDebug
     */
    public function __construct (
        HostingConfig $hostingConfig,
        ?AssetHelper $assetHelper,
        ?Packages $packages,
        string $environment,
        string $isDebug
    )
    {
        $this->hostingConfig = $hostingConfig;
        $this->assetHelper = $assetHelper;
        $this->packages = $packages;
        $this->environment = $environment;
        $this->isDebug = $isDebug;
    }


    /**
     * @return string
     */
    public function embedMonitoring () : string
    {
        if (null === $this->assetHelper && null === $this->packages)
        {
            throw new AssetIntegrationFailedException("No asset integration extension found. Please either install `becklyn/assets-bundle` or `symfony/asset` to use this bundle.");
        }

        $trackJsToken = $this->hostingConfig->getTrackJsToken();

        // only embed if token is set, in production and not in debug
        if (null === $trackJsToken || $this->isDebug || "prod" !== $this->environment)
        {
            return "";
        }

        $assetUrl = null !== $this->assetHelper
            ? $this->assetHelper->getUrl("@hosting/js/trackjs.js")
            : $this->packages->getUrl("bundles/becklynhosting/js/trackjs.js");

        return \sprintf(
            '<script src="%s"></script><script>window.TrackJS && TrackJS.install(%s)</script>',
            $assetUrl,
            \json_encode([
                "token" => $trackJsToken,
                "application" => $this->hostingConfig->getDeploymentTier(),
                "version" => $this->hostingConfig->getGitCommit(),
                "console" => [
                    "display" => false,
                ],
            ])
        );
    }

    /**
     * @inheritdoc
     */
    public function getFunctions () : iterable
    {
        return [
            new \Twig_Function("hosting_embed_monitoring", [$this, "embedMonitoring"], ["is_safe" => ["html"]]),
        ];
    }
}
