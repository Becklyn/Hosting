<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Sentry\SentryBundle\EventListener\RequestListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class SentryRequestListener
{
    private RequestListener $inner;


    public function __construct (RequestListener $inner)
    {
        $this->inner = $inner;
    }


    /**
     * We do not want to log any user details. Therefore, this method is empty.
     */
    public function handleKernelRequestEvent (RequestEvent $event) : void
    {

    }


    public function handleKernelControllerEvent (ControllerEvent $event) : void
    {
        $this->inner->handleKernelControllerEvent($event);
    }
}
