<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/11:37 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer\TerritoryDenormalizer;
use GoalAPI\SDKBundle\Model\Territory;

class TerritoryDenormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testTerritoryDenormalization()
    {
        $denormalizer = new TerritoryDenormalizer();
        $dataObject = $this->getDataObject();
        $this->assertTrue(
            $denormalizer->supportsDenormalization(
                $dataObject,
                Territory::class
            )
        );
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                $dataObject,
                \stdClass::class
            )
        );
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                new \stdClass(),
                Territory::class
            )
        );
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                '',
                Territory::class
            )
        );

        $expectedTerritory = new Territory();
        $expectedTerritory->setId($dataObject->id);
        $expectedTerritory->setName($dataObject->name);
        $parent = new Territory();
        $parent->setId($dataObject->parent->id);
        $parent->setName($dataObject->parent->name);
        $expectedTerritory->setParent($parent);

        $this->assertEquals(
            $expectedTerritory,
            $denormalizer->denormalize(
                $dataObject,
                Territory::class
            )
        );
    }

    private function getDataObject()
    {
        $dataObject = (object)[
            'id' => 'rus',
            'name' => "Russia",
            'parent' => (object)[
                'id' => 'eu',
                'name' => "Europe",
            ],
        ];

        return $dataObject;
    }
}
