<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 3/13/17/10:46 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetSubscriptionTest extends SDKTestCase
{

    function testGetSubscription()
    {
        $subscription = $this->getSDKInstance()->getSubscription();
        $this->assertEquals('ok', $subscription->getStatus());
    }
}
