<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 5:29 PM
 */

namespace GoalAPI\SDKBundle\Core\RefreshTimeRegistry;

trait RefreshTimeRegistryAwareTrait
{
    /**
     * @var RefreshTimeRegistryInterface
     */
    private $refreshTimeRegistry;

    /**
     * @param RefreshTimeRegistryInterface $refreshTimeRegistry
     */
    public function setRefreshTimeRegistry(RefreshTimeRegistryInterface $refreshTimeRegistry)
    {
        $this->refreshTimeRegistry = $refreshTimeRegistry;
    }
}