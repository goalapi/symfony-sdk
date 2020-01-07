<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetSeasonsTest extends SDKTestCase
{

    public function testGetSeasons()
    {

        /** @var SDKBundle\GoalAPISDK $theSDK */
        $theSDK = $this->getSDKInstance();

        /** @var SDKBundle\Model\Tournament $tournament */
        $tournament = new SDKBundle\Model\Tournament('rus_pl');

        /** @var SDKBundle\Model\Season[] $seasons */
        $seasons = $theSDK->getSeasons($tournament);

        foreach ($seasons as $season) {
            $this->assertInstanceOf(SDKBundle\Model\Season::class, $season);
            $this->assertInstanceOf(SDKBundle\Model\Season::class, $theSDK->getSeason($tournament, $season->getId()));
        }
    }
}
