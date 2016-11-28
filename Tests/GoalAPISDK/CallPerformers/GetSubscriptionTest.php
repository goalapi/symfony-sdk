<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/3:23 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\GoalAPISDK\CallPerformers\GetSubscription;
use GoalAPI\SDKBundle\Model;

class GetSubscriptionTest extends \PHPUnit_Framework_TestCase
{

    function testGetSubscriptionCallPerformer()
    {
        $apikey = '*';
        $callPerformer = new GetSubscription($apikey);
        /** @var Model\Subscription $subscription */
        $subscription = $callPerformer->performCall([]);
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
    }

    function testGetSubscriptionSDKMethod()
    {
        $sdk = new GoalAPISDK();
        $sdk->addCallPerformer('getSubscription', new GetSubscription('*'));

        /** @var Model\Subscription $subscription */
        $subscription = $sdk->getSubscription();
        $this->assertInstanceOf(Model\Subscription::class, $subscription);
    }
}
