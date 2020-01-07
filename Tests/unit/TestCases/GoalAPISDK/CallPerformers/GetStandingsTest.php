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
use Symfony\Component\HttpFoundation\ParameterBag;

class GetStandingsTest extends GoalAPISDKTestCase
{

    use includes\Serializer\GetSampleTrait;

    public function testSDKCall()
    {
        $json = $this->getSampleJson('standings');

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($json));
        $sdk->setSerializer($this->createSerializer());
        $sdk->addCallPerformer('getStandings', new GoalAPISDK\CallPerformers\GetStandings());

        $tournament = new Model\Tournament('eng_pl');

        $season = new Model\Season();
        $season->setId('eng_pl.20162017');

        $stage = new Model\Stage();
        $stage->setId('eng_pl.20162017.main');

        /** @var Model\StandingsTable[] $tables */
        $tables = $sdk->getStandings($tournament, $season, $stage);
        $this->assertNotEmpty($tables);
        foreach ($tables as $table) {
            $this->assertInstanceOf(Model\StandingsTable::class, $table);
            $this->assertInstanceOf(Model\Tournament::class, $table->getTournament());
            $this->assertInstanceOf(Model\Season::class, $table->getSeason());
            $this->assertInstanceOf(Model\Stage::class, $table->getStage());
            $this->assertInstanceOf(ParameterBag::class, $table->getContext());
            $this->assertNotEmpty($table->getContext()->get('group'));
            $this->assertNotEmpty($table->getId());

            /** @var Model\StandingsTableRow[] $standingsTableRows */
            $standingsTableRows = $table->getRows();
            $this->assertNotEmpty($standingsTableRows);
            foreach ($standingsTableRows as $row) {
                $this->assertInstanceOf(Model\StandingsTableRow::class, $row);
                $this->assertInstanceOf(Model\Team::class, $row->getTeam());
                $this->assertGreaterThanOrEqual(0, $row->getPoints());
                $this->assertGreaterThanOrEqual(0, $row->getPosition());
                $this->assertObjectHasAttribute('won', $row->getMatches());
                $this->assertObjectHasAttribute('scored', $row->getGoals());
            }
        }
    }
}
