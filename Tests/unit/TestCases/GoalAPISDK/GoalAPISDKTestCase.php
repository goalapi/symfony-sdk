<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/10/16/8:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Tests\unit\includes\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation;

abstract class GoalAPISDKTestCase extends TestCase
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
                'hasLinks',
                'getLinks',
                'getLink',
                'getHeader',
                'getHeaders',
            ]
        );
        $response->method('getBody')->willReturn($jsonToBeLoaded);
        $response->method('hasLinks')->willReturn(false);
        $response->method('getLinks')->willReturn(new HttpFoundation\ParameterBag());
        $response->method('getHeaders')->willReturn(new HttpFoundation\ParameterBag());
        $response->method('getLink')->willReturn(null);
        $response->method('getHeader')->willReturn(null);
        $apiClient->method('makeAPICall')->willReturn($response);

        /**
         * @var GoalAPISDK\APIClient\APIClient $apiClient
         */
        return $apiClient;
    }
}
