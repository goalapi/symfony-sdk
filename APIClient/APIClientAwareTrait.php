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
    private $apiClient;

    /**
     * @return APIClientInterface
     */
    public function getApiClient()
    {
        if (!$this->apiClient) {
            throw new \RuntimeException('API Client not set for class '.static::class);
        }

        return $this->apiClient;
    }

    /**
     * @param APIClientInterface $client
     */
    public function setApiClient(APIClientInterface $client)
    {
        $this->apiClient = $client;
    }
}

