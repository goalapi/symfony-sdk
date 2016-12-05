<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:51 PM
 *
 */

namespace GoalAPI\SDKBundle\APIClient;

interface APIClientAwareInterface
{
    /**
     * @param APIClientInterface $client
     */
    public function setAPIClient(APIClientInterface $client);
}