<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 5:01 PM
 */

namespace GoalAPI\SDKBundle\Core\APIClient;

trait APIClientAwareTrait
{
    /**
     * @var APIClientInterface
     */
    private $client;

    /**
     * @param APIClientInterface $client
     */
    public function setAPIClient(APIClientInterface $client)
    {
        $this->client = $client;
    }
}