<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/10/16/8:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use Symfony\Component\Serializer;

abstract class GoalAPISDKTestCase extends \PHPUnit_Framework_TestCase
{
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

    /**
     * @return Serializer\Serializer
     */
    protected function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new GoalAPISDK\Serializer\Normalizer\SubscriptionDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\TournamentDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\SeasonDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\TerritoryDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\StageDenormalizer(),
                new ArrayDenormalizer(),
            ], [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }
}
