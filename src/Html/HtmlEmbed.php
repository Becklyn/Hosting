<?php declare(strict_types=1);

namespace Becklyn\Hosting\Html;

use Becklyn\Hosting\Config\HostingConfig;

class HtmlEmbed
{
    /** @var HostingConfig */
    private $hostingConfig;


    public function __construct (
        HostingConfig $hostingConfig
    )
    {
        $this->hostingConfig = $hostingConfig;
    }


    public function getMetaEmbedHtml () : string
    {
        return "production" !== $this->hostingConfig->getDeploymentTier()
            ? '<meta name="robots" content="noindex,nofollow">'
            : "";
    }
}
