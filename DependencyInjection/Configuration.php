<?php declare(strict_types=1);
/**
 * GoalAPI - OpenData
 * Author: Murat Erkenov <murat@11bits.net>, 11bits, Ltd., Russia
 * Date: 3/13/17 5:39 PM
 *
 */

namespace GoalAPI\SDKBundle\DependencyInjection;

use GoalAPI\SDKBundle\GoalAPISDKBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(GoalAPISDKBundle::BUNDLE_ALIAS);
        $treeBuilder->getRootNode()->children()
            ->scalarNode('base_url')
            ->info('Base URL of root endpoint of API')
            ->defaultValue('http://api.goalapi.com/v1/')
            ->end()
            ->scalarNode('apikey')
            ->info('API key to unlock access to GoalAPI.com service')
            ->defaultNull()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
