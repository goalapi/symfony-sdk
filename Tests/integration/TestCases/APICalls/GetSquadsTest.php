<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetSquadsTest extends SDKTestCase
{

    public function testGetSquads()
    {

        /** @var SDKBundle\GoalAPISDK $theSDK */
        $theSDK = $this->getSDKInstance();

        /** @var SDKBundle\Model\Tournament $tournament */
        $tournament = new SDKBundle\Model\Tournament('rus_pl');

        $season = new SDKBundle\Model\Season();
        $season->setId('rus_pl.20162017');

        $stage = new SDKBundle\Model\Stage();
        $stage->setId('rus_pl.20162017.main');

        $squads = $theSDK->getSquads($tournament, $season, $stage);
        foreach ($squads as $squad) {
            $this->assertInstanceOf(SDKBundle\Model\Squad::class, $squad);
        }
        /** @var SDKBundle\Model\Squad $squad */
        foreach (array_slice($squads, 0, 3) as $squad) {
            $getSquadResult = $theSDK->getSquad($tournament, $season, $stage, $squad->getTeam());
            $this->assertInstanceOf(SDKBundle\Model\Squad::class, $getSquadResult);
            $this->assertInstanceOf(SDKBundle\Model\Team::class, $getSquadResult->getTeam());
            foreach ($getSquadResult->getPlayers() as $playerInSquad) {
                $this->assertInstanceOf(SDKBundle\Model\PlayerInSquad::class, $playerInSquad);
                $this->assertInstanceOf(SDKBundle\Model\Player::class, $playerInSquad->getPlayer());
            }
        }
    }
}
