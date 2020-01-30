<?php declare(strict_types=1);

namespace Becklyn\Hosting\TrackJS;

use Becklyn\AssetsBundle\Helper\AssetHelper;
use Becklyn\Hosting\Config\HostingConfig;

class TrackJSEmbed
{
    /** @var HostingConfig */
    private $hostingConfig;

    /** @var string */
    private $environment;

    /** @var string */
    private $isDebug;

    /** @var AssetHelper */
    private $assetHelper;


    /**
     */
    public function __construct (
        HostingConfig $hostingConfig,
        AssetHelper $assetHelper,
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
     * Returns the embed HTML for TrackJS.
     */
    public function getEmbedHtml () : string
    {
        $trackJsToken = $this->hostingConfig->getTrackJsToken();

        // only embed if token is set, in production and not in debug
        if (null === $trackJsToken || $this->isDebug || $this->hostingConfig->isInDevelopmentTier())
        {
            return "";
        }

        return \sprintf(
            '<script src="%s"></script><script>window.TrackJS && TrackJS.install(%s)</script>',
            $this->assetHelper->getUrl("@hosting/js/trackjs.js"),
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
