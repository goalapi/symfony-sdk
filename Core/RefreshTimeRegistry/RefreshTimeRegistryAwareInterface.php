<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 5:28 PM
 */

namespace GoalAPI\SDKBundle\Core\RefreshTimeRegistry;


interface RefreshTimeRegistryAwareInterface
{
    /**
     * @param RefreshTimeRegistryInterface $refreshTimeRegistry
     */
    public function setRefreshTimeRegistry(RefreshTimeRegistryInterface $refreshTimeRegistry);
}