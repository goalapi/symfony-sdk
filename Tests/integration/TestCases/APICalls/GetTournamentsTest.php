<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 3/13/17/10:46 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration\TestCases\APICalls;

use GoalAPI\SDKBundle;
use GoalAPI\SDKBundle\Tests\integration\SDKTestCase;

class GetTournamentsTest extends SDKTestCase
{

    function testGetTournaments()
    {
        /** @var SDKBundle\GoalAPISDK $sdk */
        $sdk = $this->getSDKInstance();
        $tournaments = $sdk->getTournaments();
        $this->assertTrue(is_array($tournaments) && sizeof($tournaments));
        foreach ($tournaments as $tournament) {
            $this->assertInstanceOf(SDKBundle\Model\Tournament::class, $tournament);
        }
        /** @var SDKBundle\Model\Tournament $tournament */
        foreach (array_slice($tournaments, 0, 5) as $tournament) {
            $tournamentId = $tournament->getId();
            $this->assertEquals($tournamentId, $sdk->getTournament($tournamentId)->getId());
        }
    }
}
