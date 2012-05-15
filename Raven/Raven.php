<?php
namespace Kunstmaan\SentryBundle\Raven;

use Raven_Client;

class Raven extends Raven_Client
{

    /**
     * @var string
     */
    private $environment;

    function __construct($dsn, $environment)
    {
        $this->environment = $environment;
        $options = array();
        $options['auto_log_stacks'] = true;
        if (isset($_SERVER["SERVER_NAME"])){
            $options['name'] = $_SERVER["SERVER_NAME"];
        }
        parent::__construct($dsn, $options);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}
