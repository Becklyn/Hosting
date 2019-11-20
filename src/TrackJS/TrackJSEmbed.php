<?php declare(strict_types=1);

namespace Becklyn\Hosting\TrackJS;

use Becklyn\AssetsBundle\Helper\AssetHelper;
use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\Exception\AssetIntegrationFailedException;
use Symfony\Component\Asset\Packages;

class TrackJSEmbed
{
    /**
     * @var HostingConfig
     */
    private $hostingConfig;

    /**
     * @var bool
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
     */
    public function __construct (
        HostingConfig $hostingConfig,
        ?AssetHelper $assetHelper,
        ?Packages $packages,
        bool $isDebug
    )
    {
        $this->hostingConfig = $hostingConfig;
        $this->assetHelper = $assetHelper;
        $this->packages = $packages;
        $this->isDebug = $isDebug;
    }


    /**
     * Returns the embed HTML for TrackJS.
     */
    public function getEmbedHtml () : string
    {
        if (null === $this->assetHelper && null === $this->packages)
        {
            throw new AssetIntegrationFailedException("No asset integration extension found. Please either install `becklyn/assets-bundle` or `symfony/asset` to use this bundle.");
        }

        $trackJsToken = $this->hostingConfig->getTrackJsToken();

        // only embed if token is set, in production and not in debug
        if (null === $trackJsToken || $this->isDebug || $this->hostingConfig->isInDevelopmentTier())
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
                "application" => $this->hostingConfig->getProjectName(),
                "version" => $this->hostingConfig->getGitCommit(),
                "console" => [
                    "display" => false,
                ],
            ])
        );
    }
}
