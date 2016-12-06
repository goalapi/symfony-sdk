<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:52 PM
 *
 */

namespace GoalAPI\SDKBundle\APIClient;

trait APIClientAwareTrait
{

    /**
     * @var APIClientInterface
     */
    protected $apiClient;

    /**
     * @param APIClientInterface $client
     */
    public function setApiClient(APIClientInterface $client)
    {
        $this->apiClient = $client;
    }
}

