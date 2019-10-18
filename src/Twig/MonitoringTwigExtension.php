<?php declare(strict_types=1);

namespace Becklyn\Hosting\Twig;

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\TrackJS\TrackJSEmbed;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;


class MonitoringTwigExtension extends AbstractExtension
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
            new TwigFunction("hosting_embed_monitoring", [$this->trackJSEmbed, "getEmbedHtml"], ["is_safe" => ["html"]]),
            new TwigFunction("hosting_tier", [$this->hostingConfig, "getDeploymentTier"]),
        ];
    }
}
