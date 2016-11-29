<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:52 PM
 *
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
