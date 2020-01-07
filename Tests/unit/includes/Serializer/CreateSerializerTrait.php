<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/14/16/8:44 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\includes\Serializer;

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
                new GoalAPISDK\Serializer\Normalizer\MatchDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\TeamDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\PlayerInSquadDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\PlayerDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\SquadDenormalizer(),
                new GoalAPISDK\Serializer\Normalizer\StandingsTableDenormalizer(),
                new ArrayDenormalizer(),
            ], [
                new Serializer\Encoder\JsonDecode(),
            ]
        );

        return $serializer;
    }
}
