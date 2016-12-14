<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit;

use GoalAPI\SDKBundle\GoalAPISDK;

class GoalAPISDKTest extends \PHPUnit_Framework_TestCase
{

    public function testAddCallPerformer()
    {
        $callName = 'performGenericCall';
        $arguments = [
            'va1',
            'val2',
        ];

        $theSdk = new GoalAPISDK();
        $theSdk->addCallPerformer($callName, new CallPerformer\GenericCallPerformer());
        $this->assertEquals(
            $arguments,
            $theSdk->makeCall($callName, $arguments),
            "Checks call result after 'makeCall' "
        );
        $this->assertEquals(
            $arguments,
            $theSdk->$callName($arguments[0], $arguments[1]),
            "Checks call result after 'SDK::performGenericCall()' "
        );
    }

    public function testSetCallPerformers()
    {
        $callName = 'performGenericCall';
        $arguments = [
            'va1',
            'val2',
        ];
        $theSdk = new GoalAPISDK();
        $theSdk->setCallPerformers(
            [
                $callName => new CallPerformer\GenericCallPerformer(),
            ]
        );
        $this->assertEquals(
            $arguments,
            $theSdk->makeCall($callName, $arguments),
            "Checks call result after 'makeCall' "
        );
        $this->assertEquals(
            $arguments,
            $theSdk->$callName($arguments[0], $arguments[1]),
            "Checks call result after 'SDK::performGenericCall()' "
        );
    }

    public function testUndefinedCall()
    {
        $theSdk = new GoalAPISDK();
        $theSdk->setCallPerformers(
            [
                'performGenericCall' => new CallPerformer\GenericCallPerformer(),
            ]
        );
        $this->expectException(\BadMethodCallException::class);
        $theSdk->someUndefinedMethod();
    }
}
