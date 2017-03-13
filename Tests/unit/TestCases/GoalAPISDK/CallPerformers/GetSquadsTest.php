<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:41 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\unit\includes;
use GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\GoalAPISDKTestCase;

class GetSquadsTest extends GoalAPISDKTestCase
{

    use includes\Serializer\GetSampleTrait;

    public function testSDKCall()
    {
        $json = $this->getSampleJson('squads');

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($json));
        $sdk->setSerializer($this->createSerializer());
        $sdk->addCallPerformer('getSquads', new GoalAPISDK\CallPerformers\GetSquads());

        $tournament = new Model\Tournament();
        $tournament->setId('eng_pl');

        $season = new Model\Season();
        $season->setId('eng_pl.20162017');

        $stage = new Model\Stage();
        $stage->setId('eng_pl.20162017.main');

        /** @var Model\Squad[] $squads */
        $squads = $sdk->getSquads($tournament, $season, $stage);
        $this->assertNotEmpty($squads);
        foreach ($squads as $squad) {
            $this->assertInstanceOf(Model\Squad::class, $squad);
            $this->assertInstanceOf(Model\Team::class, $squad->getTeam());
            $this->assertEquals($tournament, $squad->getTournament());
            $this->assertEquals($season, $squad->getSeason());
            $this->assertEquals($stage, $squad->getStage());
            $this->assertNotEmpty($squad->getId());
        }
    }
}
