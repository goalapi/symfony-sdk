<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 4:59 PM
 */

namespace GoalAPI\SDKBundle\Core\APIClient;

interface APIClientAwareInterface
{
    /**
     * @param APIClientInterface $client
     */
    public function setAPIClient(APIClientInterface $client);
}