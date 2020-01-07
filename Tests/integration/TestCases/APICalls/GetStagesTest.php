<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetStagesTest extends SDKTestCase
{

    public function testGetStages()
    {

        /** @var SDKBundle\GoalAPISDK $theSDK */
        $theSDK = $this->getSDKInstance();

        /** @var SDKBundle\Model\Tournament $tournament */
        $tournament = new SDKBundle\Model\Tournament('rus_pl');

        $season = new SDKBundle\Model\Season();
        $season->setId('rus_pl.20162017');

        /** @var SDKBundle\Model\Stage[] $stages */
        $stages = $theSDK->getStages($tournament, $season);

        /** @var SDKBundle\Model\Stage $stage */
        foreach ($stages as $stage) {
            $this->assertInstanceOf(SDKBundle\Model\Stage::class, $stage);
            $getStageResult = $theSDK->getStage($tournament, $season, $stage->getId());
            $this->assertInstanceOf(SDKBundle\Model\Stage::class, $getStageResult);
        }
    }
}
