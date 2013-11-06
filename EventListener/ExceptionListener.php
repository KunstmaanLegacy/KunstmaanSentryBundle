<?php
namespace Kunstmaan\SentryBundle\EventListener;

use Kunstmaan\SentryBundle\Raven\Raven;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * ExceptionListener
 */
class ExceptionListener
{
    /**
     * @var Raven
     */
    protected $client;

    /**
     * @param Raven $client
     */
    public function __construct(Raven $client)
    {
        $this->client = $client;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     *
     * @return array|null;
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof HttpException) {
            return;
        }
        $culprit = null;
        if ($event->getRequest()->attributes->has("_controller")) {
            $culprit = $event->getRequest()->attributes->get("_controller");
        }
        $event_id = $this->client->getIdent($this->client->captureException($exception, $culprit, $this->client->getEnvironment()));

        return error_log("[$event_id] " . $exception->getMessage() . ' in: ' . $exception->getFile() . ':' . $exception->getLine());
    }
}
