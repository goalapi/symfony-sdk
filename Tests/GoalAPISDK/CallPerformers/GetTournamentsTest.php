<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/6/16/1:38 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;
use Symfony\Component\Serializer;

class GetTournamentsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTournamentsCallPerformer()
    {
        $dataObjects = $this->createDataObjects();

        $callPerformer = new GoalAPISDK\CallPerformers\GetTournaments();
        $apiClient = $this->createAPIClient($dataObjects);
        $callPerformer->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $callPerformer->setSerializer($serializer);

        /** @var Model\Tournament $tournaments */
        $tournaments = $callPerformer->performCall([]);
        $this->assertInstanceOf(Model\Tournament::class, $tournaments[0]);
    }


    public function testGetTournamentsSDKMethod()
    {
        $dataObjects = $this->createDataObjects();

        $sdk = new GoalAPISDK();

        $apiClient = $this->createAPIClient($dataObjects);
        $sdk->setApiClient($apiClient);

        $serializer = $this->createSerializer();
        $sdk->setSerializer($serializer);

        $sdk->addCallPerformer('getTournaments', new GoalAPISDK\CallPerformers\GetTournaments());

        $tournaments = $sdk->getTournaments();
        $this->assertInstanceOf(Model\Tournament::class, $tournaments[0]);
    }

    /**
     * @return array
     */
    private function createDataObjects()
    {
        $dataObjects = [
            (object)[
                'id' => 'rus_pl',
                'name' => 'Russia - Premier League',
            ],
            (object)[
                'id' => 'eng_pl',
                'name' => 'England - Premier League',
            ],
        ];

        return $dataObjects;
    }

    /**
     * @param $dataObject
     * @return GoalAPISDK\APIClient\APIClient
     */
    private function createAPIClient($dataObject)
    {
        $apiClient = $this->createPartialMock(
            GoalAPISDK\APIClient\Guzzle\Client::class,
            [
                'makeAPICall',
            ]
        );
        $response = $this->createPartialMock(
            GoalAPISDK\APIClient\APIResponse::class,
            [
                'getBody',
            ]
        );
        $response->method('getBody')->willReturn(
            json_encode($dataObject)
        );
        $apiClient->method('makeAPICall')->willReturn(
            $response
        );

        /** @var GoalAPISDK\APIClient\APIClient $apiClient */
        return $apiClient;
    }

    /**
     * @return Serializer\Serializer
     */
    private function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new Denormalizer\TournamentDenormalizer(),
            ],
            [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }
}
