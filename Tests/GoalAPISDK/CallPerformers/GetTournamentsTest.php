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

class GetTournamentsTest extends GoalAPISDKTestCase
{
    public function testGetTournamentsCallPerformer()
    {
        $callPerformer = new GoalAPISDK\CallPerformers\GetTournaments();
        $apiClient = $this->createAPIClient($this->getJson());
        $callPerformer->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $callPerformer->setSerializer($serializer);

        /** @var Model\Tournament $tournaments */
        $tournaments = $callPerformer->performCall([]);
        $this->assertInstanceOf(Model\Tournament::class, $tournaments[0]);
    }


    public function testGetTournamentsSDKMethod()
    {
        $apiClient = $this->createAPIClient($this->getJson());
        $serializer = $this->createSerializer();

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($apiClient);
        $sdk->setSerializer($serializer);
        $sdk->addCallPerformer('getTournaments', new GoalAPISDK\CallPerformers\GetTournaments());

        $tournaments = $sdk->getTournaments();
        $this->assertInstanceOf(Model\Tournament::class, $tournaments[0]);
    }

    /**
     * @return String
     */
    private function getJson()
    {
        $json = '[
            {
                "id": "rus_pl",
                "name": "Russia - Premier League"
            }, {
                "id": "eng_pl",
                "name": "England - Premier League"
            }
        ]';

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
                new ArrayDenormalizer(),
            ],
            [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }
}
