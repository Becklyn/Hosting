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
     * We do not want to log any user details. Therefore this method is empty.
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
