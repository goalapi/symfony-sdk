<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/1:53 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use PHPUnit\Framework\TestCase;

class GoalAPICallPerformerTest extends TestCase
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

    public function testPathFromIds()
    {
        $ids = [
            'rus_pl',
            'rus_pl.20162017',
            'rus_pl.20162017.main',
        ];
        $this->assertEquals('tournaments/rus_pl/seasons/20162017/stages/main', CallPerformer::pathFromIds($ids));
    }
}

class GoalAPICallPerformer extends CallPerformer
{

}
