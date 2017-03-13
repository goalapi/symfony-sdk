<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/6:30 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer\SeasonDenormalizer;
use GoalAPI\SDKBundle\Model\Season;

class SeasonDenormalizerTest extends \PHPUnit_Framework_TestCase
{

    function testObjectDenormalization()
    {
        $seasonDenormalizer = new SeasonDenormalizer();
        $dataObject = $this->getDataObject();
        $this->assertTrue(
            $seasonDenormalizer->supportsDenormalization(
                $dataObject,
                Season::class
            )
        );
        $this->assertFalse(
            $seasonDenormalizer->supportsDenormalization(
                $dataObject,
                \stdClass::class
            )
        );
        $this->assertFalse(
            $seasonDenormalizer->supportsDenormalization(
                new \stdClass(),
                Season::class
            )
        );
        $this->assertFalse(
            $seasonDenormalizer->supportsDenormalization(
                '',
                Season::class
            )
        );

        $expectedSeason = new Season();
        $expectedSeason->setName($dataObject->name);
        $seasonLink = $dataObject->_links->self->href;
        $seasonLink = trim($seasonLink, '/');
        $seasonLink = explode('/', $seasonLink);
        $seasonLink = $seasonLink[1].'.'.$seasonLink[3];
        $expectedSeason->setId($seasonLink);

        $this->assertEquals(
            $expectedSeason,
            $seasonDenormalizer->denormalize(
                $dataObject,
                Season::class
            )
        );
    }

    private function getDataObject()
    {
        $dataObject = (object)[
            'name' => "Premier League 2016/2017",
            '_links' => (object)[
                'self' => (object)[
                    'href' => "/tournaments/rus_pl/seasons/20162017",
                ],
            ],
        ];

        return $dataObject;
    }
}
