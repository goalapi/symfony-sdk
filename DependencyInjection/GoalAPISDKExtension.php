<?php
/**
 * GoalAPI - OpenData
 * Author: Murat Erkenov <murat@11bits.net>, 11bits, Ltd., Russia
 * Date: 3/13/17 5:35 PM
 *
 */

namespace GoalAPI\SDKBundle\DependencyInjection;

use GoalAPI\SDKBundle\GoalAPISDKBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class GoalAPISDKExtension extends Extension
{

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yml');

        /** @var Configuration $configuration */
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(GoalAPISDKBundle::BUNDLE_ALIAS.'.apikey', $config['apikey']);
        $container->setParameter(GoalAPISDKBundle::BUNDLE_ALIAS.'.base_url', $config['base_url']);
    }

    /**
     * @inheritdoc
     */
    public function getAlias()
    {
        return GoalAPISDKBundle::BUNDLE_ALIAS;
    }
}
