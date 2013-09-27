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
        if (!in_array($this->container->getParameter('kernel.environment'), $this->container->getParameter('kunstmaan_sentry.environments'))) {
            return;
        }

        $errorHandler = new ErrorHandler($this->container->get('sentry.client'));
        $errorHandler->registerErrorHandler(true);
        $errorHandler->registerShutdownFunction(500);
    }
}
