<?php declare(strict_types=1);

namespace Becklyn\Hosting\Twig;

use Becklyn\Hosting\Config\HostingConfig;
use Becklyn\Hosting\Html\HtmlEmbed;
use Becklyn\Hosting\TrackJS\TrackJSEmbed;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MonitoringTwigExtension extends AbstractExtension
{
    /** @var TrackJSEmbed */
    private $trackJSEmbed;

    /** @var HostingConfig */
    private $hostingConfig;

    /** @var HtmlEmbed */
    private $htmlEmbed;


    /**
     */
    public function __construct (
        TrackJSEmbed $trackJSEmbed,
        HostingConfig $hostingConfig,
        HtmlEmbed $htmlEmbed
    )
    {
        $this->trackJSEmbed = $trackJSEmbed;
        $this->hostingConfig = $hostingConfig;
        $this->htmlEmbed = $htmlEmbed;
    }


    /**
     * @inheritdoc
     */
    public function getFunctions () : iterable
    {
        return [
            new TwigFunction("hosting_embed_html_meta", [$this->htmlEmbed, "getMetaEmbedHtml"], ["is_safe" => ["html"]]),
            new TwigFunction("hosting_embed_monitoring", [$this->trackJSEmbed, "getEmbedHtml"], ["is_safe" => ["html"]]),
            new TwigFunction("hosting_tier", [$this->hostingConfig, "getDeploymentTier"]),
        ];
    }
}
