<?php declare(strict_types=1);

namespace Becklyn\Hosting\Twig;

use Becklyn\Hosting\TrackJS\TrackJSEmbed;


class MonitoringTwigExtension extends \Twig_Extension
{
    /**
     * @var TrackJSEmbed
     */
    private $trackJSEmbed;


    /**
     * @param TrackJSEmbed $trackJSEmbed
     */
    public function __construct (TrackJSEmbed $trackJSEmbed)
    {
        $this->trackJSEmbed = $trackJSEmbed;
    }


    /**
     * @inheritdoc
     */
    public function getFunctions () : iterable
    {
        return [
            new \Twig_Function("hosting_embed_monitoring", [$this->trackJSEmbed, "getEmbedHtml"], ["is_safe" => ["html"]]),
        ];
    }
}
