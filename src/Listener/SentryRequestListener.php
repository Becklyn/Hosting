<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Sentry\SentryBundle\EventListener\RequestListener;
use Sentry\SentryBundle\EventListener\RequestListenerControllerEvent;
use Sentry\SentryBundle\EventListener\RequestListenerRequestEvent;

final class SentryRequestListener
{
    /**
     * @var RequestListener
     */
    private $inner;


    public function __construct (RequestListener $inner)
    {
        $this->inner = $inner;
    }


    /**
     * Set the username from the security context by listening on core.request
     */
    public function onKernelRequest (RequestListenerRequestEvent $event) : void
    {

    }


    /**
     */
    public function onKernelController (RequestListenerControllerEvent $event) : void
    {
        $this->inner->onKernelController($event);
    }
}
