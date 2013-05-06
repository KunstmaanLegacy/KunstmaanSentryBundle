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
    
    private function getListnerResult($environments, $currentEnv = 'test')
    {
        $kernel = new \TestKernel($currentEnv , false);
        $raven = new Raven('http://public:secret@example.com/1', $kernel->getEnvironment());
        $listener = new ExceptionListener($raven, $environments);
        $request = new Request();
        $event = new GetResponseForExceptionEvent($kernel, $request, HttpKernelInterface::MASTER_REQUEST, new Exception("Test"));
        return $result = $listener->onKernelException($event);
    }

    /**
     * @dataProvider unhandledEnvironmentsProvider
     * @covers \Kunstmaan\SentryBundle\EventListener\ExceptionListener
     */
    public function testExceptionListenerWithUnhandledEnv($environments)
    {
        $result = $this->getListnerResult($environments, 'test');
        $this->assertTrue($result[0] instanceof Exception);
        $this->assertEmpty($result[1]);
        $this->assertEquals($result[2], 'test');
    }

    /**
     * @dataProvider unhandledEnvironmentsProvider
     * @covers \Kunstmaan\SentryBundle\EventListener\ExceptionListener
     */
    public function testExceptionListenerWithHandledEnv($environments)
    {
        ini_set('error_log','/dev/null');
        $result = $this->getListnerResult($environments, 'prod');
        $this->assertTrue($result);
    }

    public static function unhandledEnvironmentsProvider()
    {
        return array(
            array(array('prod', 'dev')),
            array(array('prod', 'dev', 'stage')),
            array(array('prod', 'dev', 'my_env'))
        );
    }
}
