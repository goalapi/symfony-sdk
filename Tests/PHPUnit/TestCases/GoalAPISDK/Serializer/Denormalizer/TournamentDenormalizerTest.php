<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/12:09 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\PHPUnit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;

class TournamentDenormalizerTest extends \PHPUnit_Framework_TestCase
{

    public function testDenormalizeOk()
    {
        $data = (object)[
            'id' => 'rus_pl',
            'name' => 'Russian - Premier League',
        ];

        $denormalizer = new Normalizer\TournamentDenormalizer();

        $this->assertFalse($denormalizer->supportsDenormalization($data, \stdClass::class));
        $this->assertFalse($denormalizer->supportsDenormalization([], Model\Tournament::class));
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                new \stdClass(),
                Model\Tournament::class
            )
        );
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                (object)[
                    'id' => 'ok',
                ],
                Model\Tournament::class
            )
        );

        $this->assertTrue($denormalizer->supportsDenormalization($data, Model\Tournament::class));

        $expectedTournament = new Model\Tournament();
        $expectedTournament->setId($data->id);
        $expectedTournament->setName($data->name);
        $this->assertEquals($expectedTournament, $denormalizer->denormalize($data, Model\Tournament::class));
    }
}
