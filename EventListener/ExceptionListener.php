<?php
namespace Kunstmaan\SentryBundle\EventListener;

use Raven_Client;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var Raven_Client
     */
    protected $client;

    /**
     * @param Raven_Client $client
     */
    public function __construct(Raven_Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $this->client->captureException($exception);
        error_log($exception->getMessage() . ' in: ' . $exception->getFile() . ':' . $exception->getLine());
    }
}
