<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/14/16/8:44 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\Serializer;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use Symfony\Component\Serializer;

trait CreateSerializerTrait
{

    /**
     * @return Serializer\Serializer
     */
    protected function createSerializer()
    {
        $serializer = new Serializer\Serializer(
            [
                new GoalAPISDK\Serializer\Normalizer\SubscriptionDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\TournamentDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\SeasonDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\TerritoryDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\StageDenormalizer(),
                new ArrayDenormalizer(),
            ], [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }
}
