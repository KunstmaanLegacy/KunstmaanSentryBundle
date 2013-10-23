<?php

namespace Kunstmaan\SentryBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Raven_ErrorHandler as ErrorHandler;

/**
 * KunstmaanSentryBundle
 */
class KunstmaanSentryBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if (!$this->container->getParameter('kunstmaan_sentry.enabled')) {
            return;
        }

        $errorHandler = new ErrorHandler($this->container->get('sentry.client'));
        $errorHandler->registerErrorHandler(true);
        $errorHandler->registerShutdownFunction(500);
    }
}
