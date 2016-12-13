<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/11:48 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;
use Symfony\Component\HttpFoundation\ParameterBag;

class StandingsTableDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\StandingsTable
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!is_object($data)) {
            throw new \InvalidArgumentException('Only \stdClass objects can be denormalized by '.self::class);
        }
        if (!isset($data->id)) {
            throw new \InvalidArgumentException('The first argument must have `id` property');
        }

        $standingsTable = new Model\StandingsTable();
        $standingsTable->setId($data->id);

        if (isset($data->tournament)) {
            /** @var Model\Tournament $tournament */
            $tournament = $this->denormalizer->denormalize(
                $data->tournament,
                Model\Tournament::class,
                $format,
                $context
            );
            $standingsTable->setTournament($tournament);
        }

        if (isset($data->season)) {
            /** @var Model\Season $season */
            $season = $this->denormalizer->denormalize($data->season, Model\Season::class, $format, $context);
            $standingsTable->setSeason($season);
        }

        if (isset($data->stage)) {
            /** @var Model\Stage $stage */
            $stage = $this->denormalizer->denormalize($data->stage, Model\Stage::class, $format, $context);
            $standingsTable->setStage($stage);
        }

        if (isset($data->context)) {
            $standingsTable->setContext(
                new ParameterBag(
                    (array)$data->context
                )
            );
        }

        if (isset($data->rows) && is_array($data->rows)) {
            /** @var Model\StandingsTableRow[] $standingsTableRows */
            $standingsTableRows = [];
            foreach ($data->rows as $row) {
                if (!isset($row->team)) {
                    throw new \InvalidArgumentException('Standings table row must have `team` property');
                }
                /** @var Model\Team $team */
                $team = $this->denormalizer->denormalize($row->team, Model\Team::class, $format, $context);
                /** @var Model\StandingsTableRow $standingsTableRow */
                $standingsTableRow = new Model\StandingsTableRow();
                $standingsTableRow->setTeam($team);
                if (isset($row->position)) {
                    $standingsTableRow->setPosition($row->position);
                }
                if (isset($row->points)) {
                    $standingsTableRow->setPoints($row->points);
                }
                if (isset($row->matches)) {
                    $standingsTableRow->setMatches($row->matches);
                }
                if (isset($row->goals)) {
                    $standingsTableRow->setGoals($row->goals);
                }
                $standingsTableRows[] = $standingsTableRow;
            }
            $standingsTable->setRows($standingsTableRows);
        }

        return $standingsTable;
    }


    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\StandingsTable::class) {
            return false;
        }

        return true;
    }
}
