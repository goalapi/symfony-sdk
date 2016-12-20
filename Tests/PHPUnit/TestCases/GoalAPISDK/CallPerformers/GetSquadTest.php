<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:41 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\PHPUnit\TestCases\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\PHPUnit\includes;
use GoalAPI\SDKBundle\Tests\PHPUnit\TestCases\GoalAPISDK\GoalAPISDKTestCase;

class GetSquadTest extends GoalAPISDKTestCase
{

    use includes\Serializer\GetSampleTrait;

    public function testSDKCall()
    {
        $json = $this->getSampleJson('squads/simple');

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($json));
        $sdk->setSerializer($this->createSerializer());
        $sdk->addCallPerformer('getSquad', new GoalAPISDK\CallPerformers\GetSquad());

        $tournament = new Model\Tournament();
        $tournament->setId('eng_pl');

        $season = new Model\Season();
        $season->setId('eng_pl.20162017');

        $stage = new Model\Stage();
        $stage->setId('eng_pl.20162017.main');

        /** @var Model\Squad $squad */
        $squad = $sdk->getSquad($tournament, $season, $stage, new Model\Team());
        $this->assertInstanceOf(Model\Squad::class, $squad);
        $this->assertInstanceOf(Model\Tournament::class, $squad->getTournament());
        $this->assertInstanceOf(Model\Season::class, $squad->getSeason());
        $this->assertInstanceOf(Model\Stage::class, $squad->getStage());
        $this->assertInstanceOf(Model\Team::class, $squad->getTeam());
        $this->assertNotEmpty($squad->getId());

        $playerInSquads = $squad->getPlayers();
        $this->assertNotEmpty($playerInSquads);
        foreach ($playerInSquads as $playerInSquad) {
            $this->assertInstanceOf(Model\PlayerInSquad::class, $playerInSquad);
            $this->assertInstanceOf(Model\Player::class, $playerInSquad->getPlayer());
        }
    }
}
