<?php declare(strict_types=1);
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

class GetMatchesTest extends GoalAPISDKTestCase
{

    use includes\Serializer\GetSampleTrait;

    public function testSDKCall()
    {
        $json = $this->getSampleJson('matches');

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($json));
        $sdk->setSerializer($this->createSerializer());
        $sdk->addCallPerformer('getMatches', new GoalAPISDK\CallPerformers\GetMatches());

        $tournament = new Model\Tournament('eng_pl');

        $season = new Model\Season();
        $season->setId('eng_pl.20162017');

        $stage = new Model\Stage();
        $stage->setId('eng_pl.20162017.main');

        $matches = $sdk->getMatches($tournament, $season, $stage);
        $this->assertNotEmpty($matches);
        foreach ($matches as $match) {
            $this->assertInstanceOf(Model\Match::class, $match);
        }
    }
}
