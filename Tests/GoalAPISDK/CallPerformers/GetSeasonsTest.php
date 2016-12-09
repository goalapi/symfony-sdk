<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:08 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use Symfony\Component\Serializer;

class GetSeasonsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSeasonsCallPerformer()
    {
        $json = $this->getJson();
        $dataObjects = $this->getDataObjects($json);

        $callPerformer = new GoalAPISDK\CallPerformers\GetSeasons();
        $callPerformer->setApiClient($this->createAPIClient($json));
        $callPerformer->setSerializer($this->createSerializer());

        $expectedData = [];
        foreach ($dataObjects as $dataObject) {
            $seasonLink = $dataObject->_links->self->href;
            $seasonLink = trim($seasonLink, '/');
            $seasonLink = explode('/', $seasonLink);
            $seasonId = $seasonLink[1].'.'.$seasonLink[3];

            $expectedObject = new Model\Season();
            $expectedObject->setId($seasonId);
            $expectedObject->setName($dataObject->name);
            $expectedData[] = $expectedObject;
        }

        $this->assertEquals($expectedData, $callPerformer->deserializeData($json));
    }

    /**
     * @return string
     */
    private function getJson()
    {
        $json = '
[
    {
        "name": "World Cup 2018",
        "_links": {
            "self": {
                "href": "/tournaments/wor_wc/seasons/2018"
            }
        }
    },
    {
        "name": "World Cup 2014",
        "_links": {
            "self": {
                "href": "/tournaments/wor_wc/seasons/2014"
            }
        }
    }
]            
            ';

        return $json;
    }

    /**
     * @param $json
     * @return mixed
     */
    private function getDataObjects($json)
    {
        $dataObjects = json_decode($json);

        return $dataObjects;
    }

    /**
     * @param $json
     * @return GoalAPISDK\APIClient\APIClient
     */
    private function createAPIClient($json)
    {
        $apiClient = $this->createPartialMock(GoalAPISDK\APIClient\Guzzle\Client::class, ['makeAPICall']);
        $response = $this->createPartialMock(GoalAPISDK\APIClient\APIResponse::class, ['getBody']);
        $response->method('getBody')->willReturn($json);
        $apiClient->method('makeAPICall')->willReturn($response);

        /**
         * @var GoalAPISDK\APIClient\APIClient $apiClient
         */
        return $apiClient;
    }


    /**
     * @return Serializer\Serializer
     */
    private function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new Normalizer\SubscriptionDenormalizer(),
                new Normalizer\TournamentDenormalizer(),
                new Normalizer\SeasonDenormalizer(),
                new ArrayDenormalizer(),
            ],
            [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }

}
