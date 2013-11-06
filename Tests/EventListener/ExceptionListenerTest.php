<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Kunstmaan\SentryBundle\Raven\Raven;
use Kunstmaan\SentryBundle\EventListener\ExceptionListener;

require_once __DIR__ . '/../TestKernel.php';

/**
 * ExceptionListenerTest
 */
class ExceptionListenerTest extends \PHPUnit_Framework_TestCase
{

    // TODO: Add better test (check that Sentry ExceptionListener is only triggered when Sentry bundle is enabled)
    private function getListenerResult($currentEnv = 'test')
    {
        $kernel = new \TestKernel($currentEnv, false);
        $raven = new Raven('http://public:secret@example.com/1', $kernel->getEnvironment());
        $listener = new ExceptionListener($raven);
        $request = new Request();
        $event = new GetResponseForExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, new Exception("Test"));

        return $result = $listener->onKernelException($event);
    }

    /**
     * @covers \Kunstmaan\SentryBundle\EventListener\ExceptionListener
     */
    public function testExceptionListenerWithHandledEnv()
    {
        ini_set('error_log', '/dev/null');
        $result = $this->getListenerResult(true, 'prod');
        $this->assertTrue($result);
    }
}
