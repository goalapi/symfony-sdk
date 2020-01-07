<?php declare(strict_types=1);
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
    public function denormalize($data, string $class, string $format = null, array $context = array())
    {

        $squad = new Model\Squad();
        if (isset($data->_links->self->href)) {
            $link = $data->_links->self->href;
            $link = trim($link, '/');
            $linkParts = explode('/', $link);
            $idParts = [
                $linkParts[1],
                $linkParts[3],
                $linkParts[5],
            ];
            if (sizeof($linkParts) > 7) {
                $idParts[3] = $linkParts[7];
            }
            $id = implode('.', $idParts);
            $squad->setId($id);
        }

        /** @var Model\Team $team */
        $team = $this->denormalizer->denormalize($data, Model\Team::class, $format, $context);

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
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        if ($type != Model\Squad::class) {
            return false;
        }

        return true;
    }
}
