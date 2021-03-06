<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/12:21 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use DateTime;
use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Serializer\Serializer;

class SubscriptionDenormalizerTest extends TestCase
{
    public function testDenormalizeOk()
    {
        $data = (object)[
            'status' => 'ok',
            'expirationTime' => (object)[
                'date_time' => '2017-08-01T22:49:08+00:00',
            ],
            'allowedTournaments' => [
                (object)[
                    'id' => 'rus_pl',
                    'name' => 'Russia - Premier League',
                ],
            ],
        ];

        $serializer = new Serializer(
            [
                new Normalizer\SubscriptionDenormalizer(),
                new Normalizer\TournamentDenormalizer(),
                new ArrayDenormalizer(),
            ]
        );


        $this->assertFalse($serializer->supportsDenormalization($data, stdClass::class));
        $this->assertFalse($serializer->supportsDenormalization([], Model\Subscription::class));
        $this->assertFalse(
            $serializer->supportsDenormalization(
                new stdClass(),
                Model\Subscription::class
            )
        );
        $this->assertFalse(
            $serializer->supportsDenormalization(
                (object)[
                    'status' => 'ok',
                ],
                Model\Subscription::class
            )
        );

        $this->assertTrue($serializer->supportsDenormalization($data, Model\Subscription::class));

        $expectedSubscription = new Model\Subscription();
        $expectedSubscription->setStatus($data->status);
        $expectedSubscription->setExpirationTime(new DateTime($data->expirationTime->date_time));

        $expectedTournament = new Model\Tournament($data->allowedTournaments[0]->id);
        $expectedTournament->setName($data->allowedTournaments[0]->name);

        $expectedSubscription->setTournaments(
            [
                $expectedTournament,
            ]
        );

        $this->assertEquals($expectedSubscription, $serializer->denormalize($data, Model\Subscription::class));
    }
}
