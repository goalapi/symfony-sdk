<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class ProviderTest extends SDKTestCase
{

    public function test404()
    {

        /** @var SDKBundle\GoalAPISDK $theSDK */
        $theSDK = $this->getSDKInstance();

        /** @var SDKBundle\Model\Tournament $tournament */
        $tournament = new SDKBundle\Model\Tournament('rus_pl');

        $season = new SDKBundle\Model\Season();
        $season->setId('rus_pl.20162017');

        $stageId = 'rus_pl.20162017.zopa';
        $this->expectException(SDKBundle\SDK\Exception\SDKException::class);
        $theSDK->getStage($tournament, $season, $stageId);
    }
}
