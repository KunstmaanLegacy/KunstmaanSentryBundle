<?php
use Symfony\Component\HttpKernel\Kernel;

require_once __DIR__.'../TestKernel.php';

class RavenTest extends \PHPUnit_Framework_TestCase
{
    public function testRavenClient()
    {
        $kernel = new \TestKernel('prod', false);
        $environment = $kernel->getEnvironment();
        $raven = new \Kunstmaan\SentryBundle\Raven\Raven('http://public:secret@example.com/1', $environment);

        $this->assertEquals($raven->project, 1);
        $this->assertEquals($raven->servers, array('https://example.com/api/store/'));
        $this->assertEquals($raven->public_key, 'public');
        $this->assertEquals($raven->secret_key, 'secret');
        $this->assertEquals($raven->getEnvironment(), $environment);

    }
}
