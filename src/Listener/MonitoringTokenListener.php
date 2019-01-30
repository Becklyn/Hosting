<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Becklyn\Hosting\Config\HostingConfig;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class MonitoringTokenListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $uptimeHtmlEmbed;


    /**
     * @param HostingConfig $config
     */
    public function __construct (HostingConfig $config)
    {
        $this->uptimeHtmlEmbed = $config->getUptimeMonitorHtmlString();
    }


    /**
     * @param FilterResponseEvent $event
     */
    public function onResponse (FilterResponseEvent $event) : void
    {
        // skip if not master request
        if (null === $this->uptimeHtmlEmbed || !$event->isMasterRequest())
        {
            return;
        }

        $response = $event->getResponse();

        // skip if not HTML response
        if (false === \strpos($response->headers->get("Content-Type"), "text/html"))
        {
            return;
        }

        $content = $response->getContent();

        if (\is_string($content) && false !== ($position = \strrpos($content, '</body>')))
        {
            $content = \substr($content, 0, $position)
                . $this->uptimeHtmlEmbed
                . \substr($content, $position);

            $response->setContent($content);
        }
    }


    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents () : array
    {
        return [
            KernelEvents::RESPONSE => "onResponse",
        ];
    }
}
