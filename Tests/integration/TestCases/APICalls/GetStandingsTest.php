<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetStandingsTest extends SDKTestCase
{

    public function testGetStandings()
    {

        /** @var SDKBundle\GoalAPISDK $theSDK */
        $theSDK = $this->getSDKInstance();

        /** @var SDKBundle\Model\Tournament $tournament */
        $tournament = new SDKBundle\Model\Tournament();
        $tournament->setId('rus_pl');

        $season = new SDKBundle\Model\Season();
        $season->setId('rus_pl.20162017');

        $stage = new SDKBundle\Model\Stage();
        $stage->setId('rus_pl.20162017.main');

        foreach ($theSDK->getStandings($tournament, $season, $stage) as $standingsTable) {
            $this->assertInstanceOf(SDKBundle\Model\StandingsTable::class, $standingsTable);
            foreach ($standingsTable->getRows() as $standingsTableRow) {
                $this->assertInstanceOf(SDKBundle\Model\StandingsTableRow::class, $standingsTableRow);
                $this->assertInstanceOf(SDKBundle\Model\Team::class, $standingsTableRow->getTeam());
            }
        }
    }
}
