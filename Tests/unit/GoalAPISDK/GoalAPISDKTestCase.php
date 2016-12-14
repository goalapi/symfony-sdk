<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/10/16/8:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\GoalAPISDK;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Tests\unit\Serializer;

abstract class GoalAPISDKTestCase extends \PHPUnit_Framework_TestCase
{
    use Serializer\CreateSerializerTrait;

    /**
     * @param $jsonToBeLoaded
     * @return GoalAPISDK\APIClient\APIClient
     */
    protected function createAPIClient($jsonToBeLoaded)
    {
        $apiClient = $this->createPartialMock(
            GoalAPISDK\APIClient\Guzzle\Client::class,
            [
                'makeAPICall',
            ]
        );
        $response = $this->createPartialMock(
            GoalAPISDK\APIClient\APIResponse::class,
            [
                'getBody',
            ]
        );
        $response->method('getBody')->willReturn(
            $jsonToBeLoaded
        );
        $apiClient->method('makeAPICall')->willReturn(
            $response
        );

        /**
         * @var GoalAPISDK\APIClient\APIClient $apiClient
         */
        return $apiClient;
    }
}
