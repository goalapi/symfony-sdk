<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/12:21 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\Serializer\Denormalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class SubscriptionDenormalizerTest extends \PHPUnit_Framework_TestCase
{
    public function testDenormalizeOk()
    {
        $data = (object)[
            'status' => 'ok',
            'expirationTime' => (object)[
                'date_time' => '2017-08-01T22:49:08+00:00',
            ],
        ];


        $denormalizer = new Denormalizer\SubscriptionDenormalizer();

        $this->assertFalse($denormalizer->supportsDenormalization($data, \stdClass::class));
        $this->assertFalse($denormalizer->supportsDenormalization([], Model\Subscription::class));
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                new \stdClass(),
                Model\Subscription::class
            )
        );
        $this->assertFalse(
            $denormalizer->supportsDenormalization(
                (object)[
                    'status' => 'ok',
                ],
                Model\Subscription::class
            )
        );

        $this->assertTrue($denormalizer->supportsDenormalization($data, Model\Subscription::class));

        $expectedSubscription = new Model\Subscription();
        $expectedSubscription->setStatus($data->status);
        $expectedSubscription->setExpirationTime(new \DateTime($data->expirationTime->date_time));

        $this->assertEquals($expectedSubscription, $denormalizer->denormalize($data, Model\Subscription::class));
    }
}
