<?php declare(strict_types=1);

namespace Becklyn\Hosting\Listener;

use Sentry\SentryBundle\EventListener\ExceptionListener;
use Sentry\SentryBundle\EventListener\SentryExceptionListenerInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

final class SentryExceptionListener implements SentryExceptionListenerInterface
{
    /**
     * @var ExceptionListener
     */
    private $inner;


    public function __construct (ExceptionListener $inner)
    {
        $this->inner = $inner;
    }


    /**
     * @inheritDoc
     */
    public function onKernelRequest (GetResponseEvent $event) : void
    {

    }


    /**
     * @inheritDoc
     */
    public function onKernelException (GetResponseForExceptionEvent $event) : void
    {
        $this->inner->onKernelException($event);
    }


    /**
     * @inheritDoc
     */
    public function onConsoleError (ConsoleErrorEvent $event) : void
    {
        $this->inner->onConsoleError($event);
    }


    public function onConsoleCommand (ConsoleCommandEvent $event) : void
    {
        $this->inner->onConsoleCommand($event);
    }


    /**
     * @inheritDoc
     */
    public function onConsoleException (ConsoleExceptionEvent $event) : void
    {
        $this->inner->onConsoleException($event);
    }
}
