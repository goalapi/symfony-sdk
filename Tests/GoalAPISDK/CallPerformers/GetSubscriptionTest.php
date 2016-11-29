<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/3:23 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;

class GetSubscriptionTest extends \PHPUnit_Framework_TestCase
{

    function testGetSubscriptionCallPerformer()
    {
        $dataObject = $this->createDataObject();
        $callPerformer = $this->createCallPerformer($dataObject);

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
     * @return GoalAPISDK\CallPerformers\GetSubscription
     */
    private function createCallPerformer($dataObject)
    {
        $apiClient = $this->createPartialMock(
            GoalAPISDK\APIClient\Guzzle\Client::class,
            [
                'makeAPICall',
            ]
        );
        $response = $this->createPartialMock(
            GoalAPISDK\APIClient\Guzzle\Response::class,
            [
                'getData',
            ]
        );
        $response->method('getData')->willReturn(
            $dataObject
        );
        $apiClient->method('makeAPICall')->willReturn(
            $response
        );

        $callPerformer = new GoalAPISDK\CallPerformers\GetSubscription();
        $callPerformer->setApiClient($apiClient);

        return $callPerformer;
    }

    function testGetSubscriptionSDKMethod()
    {
        $dataObject = $this->createDataObject();
        $callPerformer = $this->createCallPerformer($dataObject);
        $sdk = new GoalAPISDK();
        $sdk->addCallPerformer('getSubscription', $callPerformer);

        $subscription = $sdk->getSubscription();
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
        $this->assertEquals(new \DateTime($dataObject->expirationTime->date_time), $subscription->getExpirationTime());
    }
}
