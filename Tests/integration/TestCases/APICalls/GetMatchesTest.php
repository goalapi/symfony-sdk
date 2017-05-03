<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 4/10/17/7:48 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetMatchesTest extends SDKTestCase
{

    public function testGetMatches()
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

        /** @var SDKBundle\Model\Match[] $matches */
        $matches = $theSDK->getMatches($tournament, $season, $stage);

        foreach ($matches as $matchFromCollection) {
            $this->assertInstanceOf(SDKBundle\Model\Match::class, $matchFromCollection);
        }

        $matches = array_slice($matches, 0, 5);
        foreach ($matches as $matchFromCollection) {
            $matchFromAPI = $theSDK->getMatch(
                $matchFromCollection->getTournament(),
                $matchFromCollection->getSeason(),
                $matchFromCollection->getStage(),
                $matchFromCollection->getId()
            );
            $this->assertInstanceOf(SDKBundle\Model\Match::class, $matchFromAPI);

            foreach ($matchFromAPI->getEvents() as $matchEvent) {
                $this->assertInstanceOf(SDKBundle\Model\MatchProperties\MatchEvent::class, $matchEvent);
            }

            foreach ($matchFromAPI->getHostsPlayers() + $matchFromAPI->getVisitorsPlayers() as $playerInSquad) {
                $this->assertInstanceOf(
                    SDKBundle\Model\PlayerInSquad::class,
                    $playerInSquad
                );
                $this->assertInstanceOf(
                    SDKBundle\Model\Player::class,
                    $playerInSquad->getPlayer()
                );
            }
        }
    }
}
