<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/3:23 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\unit\GoalAPISDK\GoalAPISDKTestCase;

class GetSubscriptionTest extends GoalAPISDKTestCase
{

    function testGetSubscriptionCallPerformer()
    {
        $json = $this->getJson();
        $dataObject = json_decode($json);
        $callPerformer = new GoalAPISDK\CallPerformers\GetSubscription();

        $apiClient = $this->createAPIClient($json);
        $callPerformer->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $callPerformer->setSerializer($serializer);

        /** @var Model\Subscription $subscription */
        $subscription = $callPerformer->performCall([]);
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
        $this->assertEquals(new \DateTime($dataObject->expirationTime->date_time), $subscription->getExpirationTime());
    }

    function testGetSubscriptionSDKMethod()
    {
        $json = $this->getJson();
        $dataObject = json_decode($json);
        $sdk = new GoalAPISDK();

        $apiClient = $this->createAPIClient($json);
        $sdk->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $sdk->setSerializer($serializer);

        $sdk->addCallPerformer('getSubscription', new GoalAPISDK\CallPerformers\GetSubscription());

        $subscription = $sdk->getSubscription();
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
        $this->assertEquals(new \DateTime($dataObject->expirationTime->date_time), $subscription->getExpirationTime());
    }

    /**
     * @return String
     */
    private function getJson()
    {
        $json = '{
            "status": "ok",
            "allowedTournaments": [
                {
                    "id": "rus_pl",
                    "name": "Russia - Premier League"
                }, {
                    "id": "eng_pl",
                    "name": "England - Premier League"
                }
            ],
            "expirationTime": {
                "date_time": "2017-08-01T22:49:08+00:00",
                "timestamp": 1501627748
            }
        }';

        return $json;
    }
}
