<?php
namespace Kunstmaan\SentryBundle\Raven;

use Raven_Client;

class Raven extends Raven_Client
{

    function __construct($dsn)
    {
        $options = array();
        $options['auto_log_stacks'] = true;
        // workaround for notice error
        //error_reporting(E_ALL ^ E_NOTICE);
        parent::__construct($dsn, $options);
    }
}
