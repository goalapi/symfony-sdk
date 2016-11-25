<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 5:28 PM
 */

namespace GoalAPI\SDKBundle\Core\RefreshTimeRegistry;


interface RefreshTimeRegistryInterface
{
    /**
     * Sets next refresh time for key
     *
     * @param String $key
     * @param \DateTime $dateTime
     */
    public function setRefreshTime($key, \DateTime $dateTime);

    /**
     * Returns next refresh time for key
     *
     * @param $key
     * @return \DateTime
     */
    public function getRefreshTime($key);
}