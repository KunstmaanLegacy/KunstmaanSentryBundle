<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;


/**
 * TestKernel
 */
class TestKernel extends Kernel
{
    /**
     * Returns an array of bundles to registers.
     *
     * @return array An array of bundle instances.
     *
     * @api
     */
    public function registerBundles()
    {
    }

    /**
     * Loads the container configuration
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     *
     * @api
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}
