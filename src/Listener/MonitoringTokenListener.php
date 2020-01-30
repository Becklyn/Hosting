<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Becklyn\Hosting\Config\HostingConfig;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MonitoringTokenListener implements EventSubscriberInterface
{
    /** @var string */
    private $uptimeHtmlEmbed;


    /**
     */
    public function __construct (HostingConfig $config)
    {
        $this->uptimeHtmlEmbed = $config->getUptimeMonitorHtmlString();
    }


    /**
     */
    public function onResponse (ResponseEvent $event) : void
    {
        // skip if not master request
        if (!$event->isMasterRequest() || null === $this->uptimeHtmlEmbed)
        {
            return;
        }

        $response = $event->getResponse();
        $contentType = $response->headers->get("Content-Type");

        // skip if not HTML response
        if (null === $contentType || false === \strpos($contentType, "text/html"))
        {
            return;
        }

        $content = $response->getContent();

        if (\is_string($content) && false !== ($position = \mb_strrpos($content, '</body>')))
        {
            $content = \mb_substr($content, 0, $position)
                . $this->uptimeHtmlEmbed
                . \mb_substr($content, $position);

            $response->setContent($content);
        }
    }


    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents () : array
    {
        return [
            KernelEvents::RESPONSE => ["onResponse", -1000],
        ];
    }
}
