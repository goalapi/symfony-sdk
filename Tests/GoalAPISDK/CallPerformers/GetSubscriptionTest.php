<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/3:23 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;
use Symfony\Component\Serializer;

class GetSubscriptionTest extends \PHPUnit_Framework_TestCase
{

    function testGetSubscriptionCallPerformer()
    {
        $dataObject = $this->createDataObject();
        $callPerformer = new GoalAPISDK\CallPerformers\GetSubscription();

        $apiClient = $this->createAPIClient($dataObject);
        $callPerformer->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $callPerformer->setSerializer($serializer);

        /** @var Model\Subscription $subscription */
        $subscription = $callPerformer->performCall([]);
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
        $this->assertEquals(new \DateTime($dataObject->expirationTime->date_time), $subscription->getExpirationTime());

    }

    /**
     * @return object
     */
    private function createDataObject()
    {
        $dataObject = (object)[
            'status' => 'ok',
            'allowedTournaments' => [
                (object)[
                    'id' => 'rus_pl',
                    'name' => 'Russia - Premier League',
                ],
                (object)[
                    'id' => 'eng_pl',
                    'name' => 'England - Premier League',
                ],
            ],
            'expirationTime' => (object)[
                'date_time' => '2017-08-01T22:49:08+00:00',
                'timestamp' => 1501627748,
            ],
        ];

        return $dataObject;
    }

    /**
     * @param $dataObject
     * @return GoalAPISDK\APIClient\Guzzle\Client
     */
    private function createAPIClient($dataObject)
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
            json_encode($dataObject)
        );
        $apiClient->method('makeAPICall')->willReturn(
            $response
        );

        return $apiClient;
    }

    /**
     * @return Serializer\Serializer
     */
    private function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new Denormalizer\SubscriptionDenormalizer(),
                new Denormalizer\TournamentDenormalizer(),
            ],
            [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }

    function testGetSubscriptionSDKMethod()
    {
        $dataObject = $this->createDataObject();

        $sdk = new GoalAPISDK();

        $apiClient = $this->createAPIClient($dataObject);
        $sdk->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $sdk->setSerializer($serializer);

        $sdk->addCallPerformer('getSubscription', new GoalAPISDK\CallPerformers\GetSubscription());

        $subscription = $sdk->getSubscription();
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
        $this->assertEquals(new \DateTime($dataObject->expirationTime->date_time), $subscription->getExpirationTime());
    }
}
