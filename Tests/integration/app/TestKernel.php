<?php

/**
 * Author: Murat Erkenov
 * Date/Time: 3/13/17/10:24 PM
 *
 */
class TestKernel extends \Symfony\Component\HttpKernel\Kernel
{

    /**
     * @inheritdoc
     */
    public function registerBundles()
    {
        $bundles = [
            new GoalAPI\SDKBundle\GoalAPISDKBundle(),
        ];

        return $bundles;
    }

    /**
     * Loads the container configuration.
     *
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader A LoaderInterface instance
     */
    public function registerContainerConfiguration(\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        $configToLoad = __DIR__.'/config/config_'.$this->getEnvironment().'.yml';
        if (!is_readable($configToLoad)) {
            $configToLoad = __DIR__.'/config/config.yml';
        }
        $loader->load($configToLoad);
    }
}
