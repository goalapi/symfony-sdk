<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 4:55 PM
 */

namespace GoalAPI\SDKBundle\Core\APIClient;

interface APIClientInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function makeAPICall($url);
}