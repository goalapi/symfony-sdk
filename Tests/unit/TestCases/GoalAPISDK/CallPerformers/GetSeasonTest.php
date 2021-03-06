<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:08 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\GoalAPISDKTestCase;

class GetSeasonTest extends GoalAPISDKTestCase
{
    public function testCallPerformer()
    {
        $json = $this->getJson();
        $dataObject = \GuzzleHttp\json_decode($json);

        $callPerformer = new GoalAPISDK\CallPerformers\GetSeason();
        $callPerformer->setApiClient($this->createAPIClient($json));
        $callPerformer->setSerializer($this->createSerializer());

        $expectedObject = $this->getExpectedObject($dataObject);

        $this->assertEquals($expectedObject, $callPerformer->deserializeData($json));
    }

    public function testSDKCall()
    {
        $json = $this->getJson();
        $dataObject = \GuzzleHttp\json_decode($json);
        $expectedObject = $this->getExpectedObject($dataObject);

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($json));
        $sdk->setSerializer($this->createSerializer());
        $sdk->addCallPerformer('getSeason', new GoalAPISDK\CallPerformers\GetSeason());

        $this->assertEquals(
            $expectedObject,
            $sdk->getSeason(new Model\Tournament('eng_pl'), 'eng_pl.20162017')
        );
    }

    /**
     * @return string
     */
    private function getJson()
    {
        $json = '
{
    "name": "Premier League 2016/2017",
    "_links": {
        "self": {
            "href": "/tournaments/eng_pl/seasons/20162017"
        },
        "stages": {
            "href": "/tournaments/eng_pl/seasons/20162017/stages/"
        },
        "matches": {
            "href": "/tournaments/eng_pl/seasons/20162017/matches/"
        }
    },
    "tournament": {
        "id": "eng_pl",
        "name": "Premier League",
        "_links": {
            "self": {
                "href": "/tournaments/eng_pl"
            }
        },
        "coverage": {
            "id": "eng",
            "name": "England",
            "_links": {
                "self": {
                    "href": "/territories/eng"
                }
            }
        }
    },
    "stages": [
        {
            "name": "Main",
            "_links": {
                "self": {
                    "href": "/tournaments/eng_pl/seasons/20162017/stages/main"
                }
            }
        }
    ]
}
        ';
        return $json;
    }

    /**
     * @param $dataObject
     * @return Model\Season
     */
    private function getExpectedObject($dataObject)
    {
        $seasonLink = $dataObject->_links->self->href;
        $seasonLink = trim($seasonLink, '/');
        $seasonLink = explode('/', $seasonLink);
        $seasonId = $seasonLink[1].'.'.$seasonLink[3];

        $tournamentCoverage = new Model\Territory();
        $tournamentCoverage->setId($dataObject->tournament->coverage->id);
        $tournamentCoverage->setName($dataObject->tournament->coverage->name);

        $tournament = new Model\Tournament($dataObject->tournament->id);
        $tournament->setName($dataObject->tournament->name);
        $tournament->setCoverage($tournamentCoverage);

        /** @var Model\Stage[] $stages */
        $stages = [];
        foreach ($dataObject->stages as $stageObject) {
            $stageLink = $stageObject->_links->self->href;
            $stageLink = trim($stageLink, '/');
            $stageLink = explode('/', $stageLink);
            $stageId = $stageLink[1].'.'.$stageLink[3].'.'.$stageLink[5];

            $stage = new Model\Stage();
            $stage->setId($stageId);
            $stage->setName($stageObject->name);

            $stages[] = $stage;
        }

        $expectedObject = new Model\Season();
        $expectedObject->setId($seasonId);
        $expectedObject->setName($dataObject->name);
        $expectedObject->setTournament($tournament);
        $expectedObject->setStages($stages);

        return $expectedObject;
    }
}
