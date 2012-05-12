<?php

namespace Kunstmaan\SentryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Raven_Autoloader;

class KunstmaanSentryBundle extends Bundle
{
    public function boot()
    {
        parent::boot();
        require_once __DIR__ .  '/vendor/raven-php/lib/Raven/Autoloader.php';
        Raven_Autoloader::register();
    }
}
