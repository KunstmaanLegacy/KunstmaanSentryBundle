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
    /**
     * @covers \Kunstmaan\SentryBundle\EventListener\ExceptionListener
     */
    public function testExceptionListener()
    {
        $kernel = new \TestKernel('test', false);
        $raven = new Raven('http://public:secret@example.com/1', $kernel->getEnvironment());
        $listener = new ExceptionListener($raven);
        $request = new Request();
        $event = new GetResponseForExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, new Exception("Test"));
        $result = $listener->onKernelException($event);

        $this->assertTrue($result[0] instanceof Exception);
        $this->assertEmpty($result[1]);
        $this->assertEquals($result[2], 'test');
    }
}
