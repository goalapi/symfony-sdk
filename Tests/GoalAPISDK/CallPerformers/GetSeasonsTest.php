<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:08 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\GoalAPISDK\GoalAPISDKTestCase;

class GetSeasonsTest extends GoalAPISDKTestCase
{
    public function testGetSeasonsCallPerformer()
    {
        $json = $this->getJson();
        $dataObjects = json_decode($json);

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
}
