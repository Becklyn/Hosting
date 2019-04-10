<?php declare(strict_types=1);

namespace Becklyn\Hosting\Twig;

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\TrackJS\TrackJSEmbed;


class MonitoringTwigExtension extends \Twig_Extension
{
    /**
     * @var TrackJSEmbed
     */
    private $trackJSEmbed;

    /**
     * @var HostingConfig
     */
    private $hostingConfig;


    /**
     * @param TrackJSEmbed  $trackJSEmbed
     * @param HostingConfig $hostingConfig
     */
    public function __construct (TrackJSEmbed $trackJSEmbed, HostingConfig $hostingConfig)
    {
        $this->trackJSEmbed = $trackJSEmbed;
        $this->hostingConfig = $hostingConfig;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions () : iterable
    {
        return [
            new \Twig_Function("hosting_embed_monitoring", [$this->trackJSEmbed, "getEmbedHtml"], ["is_safe" => ["html"]]),
            new \Twig_Function("hosting_tier", [$this->hostingConfig, "getDeploymentTier"]),
        ];
    }
}
