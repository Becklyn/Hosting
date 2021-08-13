<?php declare(strict_types=1);

namespace Becklyn\Hosting\TrackJS;

use Becklyn\AssetsBundle\Helper\AssetHelper;
use Becklyn\Hosting\Config\HostingConfig;

class TrackJSEmbed
{
    private HostingConfig $hostingConfig;
    private bool $isDebug;
    private ?AssetHelper $assetHelper;


    public function __construct (
        HostingConfig $hostingConfig,
        ?AssetHelper $assetHelper,
        bool $isDebug
    )
    {
        $this->hostingConfig = $hostingConfig;
        $this->assetHelper = $assetHelper;
        $this->isDebug = $isDebug;
    }


    /**
     * Returns the embed HTML for TrackJS.
     *
     * @throws \JsonException
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
            $this->assetHelper->getUrl("@hosting/vendor/trackjs.js"),
            \json_encode([
                "token" => $trackJsToken,
                "application" => $this->hostingConfig->getProjectInstallationKey(),
                "version" => $this->hostingConfig->getGitCommit(),
                "console" => [
                    "display" => false,
                ],
            ], \JSON_THROW_ON_ERROR)
        );
    }
}
