<?php
namespace Kunstmaan\SentryBundle\EventListener;

use Kunstmaan\SentryBundle\Raven\Raven;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

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
     * @param Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        if ($exception instanceof HttpException) {
            return;
        }
        $culprit = null;
        if($event->getRequest()->attributes->has("_controller")){
            $culprit = $event->getRequest()->attributes->get("_controller");
        }
        $this->client->captureException($exception, $culprit, $this->client->getEnvironment());
        error_log($exception->getMessage() . ' in: ' . $exception->getFile() . ':' . $exception->getLine());
    }
}
