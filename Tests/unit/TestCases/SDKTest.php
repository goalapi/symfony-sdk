<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases;

use GoalAPI\SDKBundle\SDK\SDK;
use GoalAPI\SDKBundle\Tests\unit\includes\CallPerformer\GenericCallPerformer;

class SDKTest extends \PHPUnit_Framework_TestCase
{

    public function testAddCallPerformer()
    {
        $callName = 'performGenericCall';
        $arguments = [
            'va1',
            'val2',
        ];

        $theSdk = new SDK();
        $theSdk->addCallPerformer($callName, new GenericCallPerformer());
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
        $theSdk = new SDK();
        $theSdk->setCallPerformers(
            [
                $callName => new GenericCallPerformer(),
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
        $theSdk = new SDK();
        $theSdk->setCallPerformers(
            [
                'performGenericCall' => new GenericCallPerformer(),
            ]
        );
        $this->expectException(\BadMethodCallException::class);
        $theSdk->someUndefinedMethod();
    }
}
