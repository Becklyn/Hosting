<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Sentry\SentryBundle\EventListener\RequestListener;
use Sentry\SentryBundle\EventListener\RequestListenerControllerEvent;
use Sentry\SentryBundle\EventListener\RequestListenerRequestEvent;
use Sentry\SentrySdk;
use Sentry\State\Scope;

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
        if (!$event->isMasterRequest())
        {
            return;
        }

        $currentClient = SentrySdk::getCurrentHub()->getClient();

        if (null === $currentClient || !$currentClient->getOptions()->shouldSendDefaultPii())
        {
            return;
        }

        $userData = [];
        $userData['ip_address'] = $event->getRequest()->getClientIp();

        SentrySdk::getCurrentHub()->configureScope(function (Scope $scope) use ($userData) : void {
             $scope->setUser($userData, true);
        });
    }


    /**
     */
    public function onKernelController (RequestListenerControllerEvent $event) : void
    {
        $this->inner->onKernelController($event);
    }
}
