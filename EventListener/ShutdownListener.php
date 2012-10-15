<?php
namespace Kunstmaan\SentryBundle\EventListener;


use Kunstmaan\SentryBundle\Raven\Raven;
use RuntimeException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * ShutdownListener
 */
class ShutdownListener
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
     * Register the handler on the request.
     *
     * @param FilterControllerEvent $event
     */
    public function register(FilterControllerEvent $event)
    {
        register_shutdown_function(array($this, 'onShutdown'));
    }

    /**
     * Handles the PHP shutdown event.
     *
     * This event exists almost solely to provide a means to catch and log errors that might have been
     * otherwise lost when PHP decided to die unexpectedly.
     */
    public function onShutdown()
    {
        // Get the last error if there was one, if not, let's get out of here.
        if (!$error = error_get_last()) {
            return;
        }

        $fatal  = array(E_ERROR,E_PARSE,E_CORE_ERROR,E_COMPILE_ERROR,E_USER_ERROR,E_RECOVERABLE_ERROR);
        if (!in_array($error['type'], $fatal)) {
            return;
        }

        $message   = '[Shutdown Error]: %s';
        $message   = sprintf($message, $error['message']);
        $exception = new RuntimeException($message.' in: '.$error['file'].':'.$error['line']);
        $culprit = $error['file'];
        if ($this->client->getEnvironment() != 'prod') {
            return array($exception, $culprit, $this->client->getEnvironment());
        } else {
            $event_id = $this->client->getIdent($this->client->captureException($exception, $culprit, $this->client->getEnvironment()));
            error_log("[$event_id] " . $message.' in: '.$error['file'].':'.$error['line']);
        }
    }
}
