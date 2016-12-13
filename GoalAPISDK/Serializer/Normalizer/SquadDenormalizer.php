<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/12/16/7:40 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class SquadDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\Squad
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        /** @var Model\Team $team */
        $team = $this->denormalizer->denormalize($data, Model\Team::class, $format, $context);

        $squad = new Model\Squad();
        $squad->setTeam($team);

        if (isset($data->tournament)) {
            /** @var Model\Tournament $tournament */
            $tournament = $this->denormalizer->denormalize(
                $data->tournament,
                Model\Tournament::class,
                $format,
                $context
            );
            $squad->setTournament($tournament);
        }

        if (isset($data->season)) {
            /** @var Model\Season $season */
            $season = $this->denormalizer->denormalize(
                $data->season,
                Model\Season::class,
                $format,
                $context
            );
            $squad->setSeason(
                $season
            );
        }

        if (isset($data->stage)) {
            /** @var Model\Stage $stage */
            $stage = $this->denormalizer->denormalize(
                $data->stage,
                Model\Stage::class,
                $format,
                $context
            );
            $squad->setStage(
                $stage
            );
        }

        if (isset($data->players)) {
            /** @var Model\PlayerInSquad[] $players */
            $players = $this->denormalizer->denormalize(
                $data->players,
                Model\PlayerInSquad::class.'[]',
                $format,
                $context
            );
            $squad->setPlayers($players);
        }

        return $squad;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\Squad::class) {
            return false;
        }

        return true;
    }
}
