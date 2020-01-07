<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/6:30 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer\StageDenormalizer;
use GoalAPI\SDKBundle\Model;
use PHPUnit\Framework\TestCase;
use stdClass;

class StageDenormalizerTest extends TestCase
{

    function testObjectDenormalization()
    {
        $stageDenormalizer = new StageDenormalizer();
        $json = $this->getJson();
        $dataObject = \GuzzleHttp\json_decode($json);
        $this->assertTrue(
            $stageDenormalizer->supportsDenormalization(
                $dataObject,
                Model\Stage::class
            )
        );
        $this->assertFalse(
            $stageDenormalizer->supportsDenormalization(
                $dataObject,
                stdClass::class
            )
        );
        $this->assertFalse(
            $stageDenormalizer->supportsDenormalization(
                new stdClass(),
                Model\Stage::class
            )
        );
        $this->assertFalse(
            $stageDenormalizer->supportsDenormalization(
                '',
                Model\Stage::class
            )
        );

        $expectedStage = new Model\Stage();
        $expectedStage->setName($dataObject->name);
        $seasonLink = $dataObject->_links->self->href;
        $seasonLink = trim($seasonLink, '/');
        $seasonLink = explode('/', $seasonLink);
        $seasonLink = $seasonLink[1].'.'.$seasonLink[3].'.'.$seasonLink[5];
        $expectedStage->setId($seasonLink);

        $this->assertEquals(
            $expectedStage,
            $stageDenormalizer->denormalize(
                $dataObject,
                Model\Stage::class
            )
        );
    }

    private function getJson()
    {
        $json = '{
            "name": "Main",
            "_links": {
                "self": {
                    "href": "/tournaments/eng_pl/seasons/20162017/stages/main"
                }
            }
        }';

        return $json;
    }
}
