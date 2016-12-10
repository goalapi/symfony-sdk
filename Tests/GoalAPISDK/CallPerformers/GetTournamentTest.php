<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/6/16/1:38 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use GoalAPI\SDKBundle\Tests\GoalAPISDK\GoalAPISDKTestCase;
use Symfony\Component\Serializer;

class GetTournamentTest extends GoalAPISDKTestCase
{

    public function testGetTournamentCallPerformer()
    {
        $json = $this->getJson();
        $dataObject = json_decode($json);

        $callPerformer = new GoalAPISDK\CallPerformers\GetTournament();
        $apiClient = $this->createAPIClient($json);
        $callPerformer->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $callPerformer->setSerializer($serializer);

        /** @var Model\Tournament $tournament */
        $tournament = $callPerformer->performCall([$dataObject->id]);
        $expectedTournament = $this->getExpectedTournament($dataObject);
        $this->assertEquals($expectedTournament, $tournament);
    }

    /**
     * @return String
     */
    private function getJson()
    {
        $json = '{
            "id": "rus_pl",
            "name": "Russia - Premier League",
            "coverage": {
                "id": "rus",
                "name": "Russia"            
            },
            "season": {
                "name": "Premier League 2016/2017",
                "_links": {
                    "self": {
                        "href": "/tournaments/rus_pl/seasons/20162017"
                    }
                } 
            },
            "teams_type": "club"
        }';

        return $json;
    }

    /**
     * @return Serializer\Serializer
     */
    private function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new Normalizer\TournamentDenormalizer(),
                new Normalizer\TerritoryDenormalizer(),
                new Normalizer\SeasonDenormalizer(),
                new ArrayDenormalizer(),
            ],
            [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }

    /**
     * @param \stdClass $dataObject
     * @return Model\Tournament
     */
    private function getExpectedTournament(\stdClass $dataObject)
    {
        $expectedTournament = new Model\Tournament();

        $expectedTournament->setId($dataObject->id);
        $expectedTournament->setName($dataObject->name);
        $expectedTournament->setTeamsType($dataObject->teams_type);

        $expectedCoverage = new Model\Territory();
        $expectedCoverage->setId($dataObject->coverage->id);
        $expectedCoverage->setName($dataObject->coverage->name);
        $expectedTournament->setCoverage($expectedCoverage);

        $expectedSeason = new Model\Season();
        $expectedSeason->setName($dataObject->season->name);
        $seasonLink = $dataObject->season->_links->self->href;
        $seasonLink = trim($seasonLink, '/');
        $seasonLink = explode('/', $seasonLink);
        $seasonLink = $seasonLink[1].'.'.$seasonLink[3];
        $expectedSeason->setId($seasonLink);
        $expectedTournament->setActiveSeason($expectedSeason);
        return $expectedTournament;
    }
}
