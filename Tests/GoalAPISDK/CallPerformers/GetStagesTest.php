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

class GetStagesTest extends GoalAPISDKTestCase
{
    public function testCallPerformer()
    {
        $json = $this->getJson();
        $dataObjects = json_decode($json);

        $callPerformer = new GoalAPISDK\CallPerformers\GetStages();
        $callPerformer->setApiClient($this->createAPIClient($json));
        $callPerformer->setSerializer($this->createSerializer());

        $this->assertEquals(
            $this->getExpectedData($dataObjects),
            $callPerformer->deserializeData($json)
        );
    }

    /**
     * @return string
     */
    private function getJson()
    {
        $json = '
[
    {
        "name": "Final tournament",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/finaltournament"
            }
        }
    },
    {
        "name": "Play Offs",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/finaltournament.playoffs"
            }
        }
    },
    {
        "name": "Qualification",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/qualification"
            }
        }
    },
    {
        "name": "Main",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/qualification.main"
            }
        }
    },
    {
        "name": "Promotion",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/qualification.promotion"
            }
        }
    },
    {
        "name": "Main",
        "_links": {
            "self": {
                "href": "/tournaments/euro/seasons/2016/stages/finaltournament.main"
            }
        }
    }
]
            ';

        return $json;
    }

    /**
     * @param $dataObjects
     * @return array
     */
    private function getExpectedData($dataObjects)
    {
        $expectedData = [];
        foreach ($dataObjects as $dataObject) {
            $link = $dataObject->_links->self->href;
            $link = trim($link, '/');
            $link = explode('/', $link);
            $objectId = $link[1].'.'.$link[3].'.'.$link[5];

            $expectedObject = new Model\Stage();
            $expectedObject->setId($objectId);
            $expectedObject->setName($dataObject->name);
            $expectedData[] = $expectedObject;
        }

        return $expectedData;
    }
}
