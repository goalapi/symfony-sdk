<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/1:53 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;

class GoalAPICallPerformerTest extends \PHPUnit_Framework_TestCase
{

    function testCallWithNoRefresh()
    {
        $callPerformer = $this->createPartialMock(
            GoalAPICallPerformer::class,
            [
                'mustRefresh',
                'fetchDataFromLocalStorage',
            ]
        );
        $callPerformer->method('mustRefresh')->willReturn(false);
        $callPerformer->expects($this->once())->method('fetchDataFromLocalStorage');
        /** @var CallPerformer $callPerformer */
        $callPerformer->performCall([]);
    }

    function testCallWithRefresh()
    {
        $callPerformer = $this->createPartialMock(
            GoalAPICallPerformer::class,
            [
                'loadDataFromProvider',
                'saveDataToLocalStorage',
                'updateNextRefreshTime',
                'mustRefresh',
                'deserializeData',
            ]
        );
        $callPerformer->method('mustRefresh')->willReturn(true);
        $callPerformer->method('loadDataFromProvider')->willReturn([]);
        $callPerformer->expects($this->once())->method('loadDataFromProvider');
        /** @var CallPerformer $callPerformer */
        $callPerformer->performCall([]);
    }
}