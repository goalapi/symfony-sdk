<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/10:14 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use DateTime;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\ParameterBag;

class MatchDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\Match
     */
    public function denormalize($data, string $class, string $format = null, array $context = array())
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException('Only \stdClass objects can be denormalized by '.self::class);
        }
        if (!isset($data->id)) {
            throw new InvalidArgumentException('The first argument must have `id` property');
        }

        $match = new Model\Match();
        $match->setId($data->id);

        $match->setBeginTime(
            new DateTime($data->begin_time->date_time)
        );

        if (isset($data->teams[0])) {
            /** @var Model\Team $hostsTeam */
            $hostsTeam = $this->denormalizer->denormalize(
                $data->teams[0],
                Model\Team::class,
                $format,
                $context
            );
            $match->setHostsTeam($hostsTeam);

            if (isset($data->teams[0]->squad->eleven)) {
                $match->setHostsPlayers(
                    $this->processSquadItems(
                        $data->teams[0]->squad->eleven,
                        $format,
                        $context
                    )
                );
            }
            if (isset($data->teams[0]->squad->substitutions)) {
                $match->setHostsSubstitutions(
                    $this->processSquadItems(
                        $data->teams[0]->squad->substitutions,
                        $format,
                        $context
                    )
                );
            }

        }
        if (isset($data->teams[1])) {
            /** @var Model\Team $visitorsTeam */
            $visitorsTeam = $this->denormalizer->denormalize(
                $data->teams[1],
                Model\Team::class,
                $format,
                $context
            );
            $match->setVisitorsTeam($visitorsTeam);

            if (isset($data->teams[1]->squad->eleven)) {
                $match->setVisitorsPlayers(
                    $this->processSquadItems(
                        $data->teams[1]->squad->eleven,
                        $format,
                        $context
                    )
                );
            }
            if (isset($data->teams[1]->squad->substitutions)) {
                $match->setVisitorsSubstitutions(
                    $this->processSquadItems(
                        $data->teams[1]->squad->substitutions,
                        $format,
                        $context
                    )
                );
            }
        }

        if (isset($data->tournament)) {
            /** @var Model\Tournament $tournament */
            $tournament = $this->denormalizer->denormalize(
                $data->tournament,
                Model\Tournament::class,
                $format,
                $context
            );
            $match->setTournament($tournament);
        }

        if (isset($data->status->status)) {
            $status = Model\MatchProperties\MatchStatus::createInstance($data->status->status);

            if (isset($data->status->score) && is_array($data->status->score)) {
                $status->setScore($data->status->score[0], $data->status->score[1]);
            }

            if ($status instanceof Model\MatchProperties\Status\Online && isset($data->status->period)) {
                $minute = null;
                if (isset($data->status->period_finish_time->date_time)) {
                    $periodFinishDateTime = new DateTime($data->status->period_finish_time->date_time);
                    $interval = $periodFinishDateTime->diff(new DateTime());
                    $m = $interval->i;
                    switch ($data->status->period) {
                        CASE Model\MatchProperties\MatchMoment::MATCH_PERIOD_FIRST_HALF:
                            $minute = 45 - $m;
                            BREAK;

                        CASE Model\MatchProperties\MatchMoment::MATCH_PERIOD_SECOND_HALF:
                            $minute = 90 - $m;
                            BREAK;

                        CASE Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME_FIRST_HALF:
                            $minute = 105 - $m;
                            BREAK;

                        CASE Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME:
                        CASE Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME_SECOND_HALF:
                            $minute = 120 - $m;
                            BREAK;
                    }
                }
                $currentMoment = Model\MatchProperties\MatchMoment::createInstance($data->status->period, $minute);
                $status->setCurrentMoment($currentMoment);
            }

            $match->setStatus($status);
        }

        if (isset($data->events) && is_array($data->events)) {
            $eventObjects = [];
            foreach ($data->events as $eventItem) {
                if (!isset($eventItem->type)) {
                    throw new InvalidArgumentException('Event item must have `type` attribute');
                }

                $eventObject = Model\MatchProperties\MatchEvent::createEvent($eventItem->type);

                if (isset($eventItem->team)) {
                    /** @var Model\Team $team */
                    $team = $this->denormalizer->denormalize(
                        $eventItem->team,
                        Model\Team::class,
                        $format,
                        $context
                    );
                    $eventObject->setTeam($team);
                }

                if (isset($eventItem->moment->period)) {
                    $minute = null;
                    if (isset($eventItem->moment->minute)) {
                        $minute = $eventItem->moment->minute;
                    }
                    $eventObject->setMoment(
                        Model\MatchProperties\MatchMoment::createInstance($eventItem->moment->period, $minute)
                    );
                }

                if (in_array(
                    $eventItem->type,
                    [
                        Model\MatchProperties\MatchEvent::EVENT_TYPE_GOAL,
                        Model\MatchProperties\MatchEvent::EVENT_TYPE_CARD,
                        Model\MatchProperties\MatchEvent::EVENT_TYPE_PENALTY_MISSED,
                    ]
                )) {
                    if (!isset($eventItem->player)) {
                        throw new InvalidArgumentException(
                            'Event of type `'.$eventItem->type.'` must contain `player` property'
                        );
                    }

                    /** @var Model\Player $player */
                    $player = $this->denormalizer->denormalize(
                        $eventItem->player,
                        Model\Player::class,
                        $format,
                        $context
                    );

                    /** @var Model\MatchProperties\Event\Goal|Model\MatchProperties\Event\Card|Model\MatchProperties\Event\PenaltyMissed $eventObject */
                    $eventObject->setPlayer($player);
                }

                if (Model\MatchProperties\MatchEvent::EVENT_TYPE_GOAL == $eventItem->type) {
                    /** @var Model\MatchProperties\Event\Goal $eventObject */
                    if (isset($eventItem->own) && $eventItem->own) {
                        $eventObject->setOwnGoal(true);
                    }
                    if (isset($eventItem->penalty) && $eventItem->penalty) {
                        $eventObject->setPenalty(true);
                    }
                }

                if (Model\MatchProperties\MatchEvent::EVENT_TYPE_CARD == $eventItem->type) {
                    if (!isset($eventItem->color)) {
                        throw new InvalidArgumentException('Card event must have `color` property');
                    }
                    /** @var Model\MatchProperties\Event\Card $eventObject */
                    $eventObject->setColor($eventItem->color);
                }


                if (Model\MatchProperties\MatchEvent::EVENT_TYPE_SUBSTITUTION == $eventItem->type) {
                    if (!isset($eventItem->players->in) || !isset($eventItem->players->out)) {
                        throw new InvalidArgumentException('Substitution mus have IN and OUT players');
                    }
                    /** @var Model\MatchProperties\Event\Substitution $eventObject */

                    /** @var Model\Player $player */
                    $player = $this->denormalizer->denormalize(
                        $eventItem->players->in,
                        Model\Player::class,
                        $format,
                        $context
                    );
                    $eventObject->setPlayerIn($player);

                    /** @var Model\Player $player */
                    $player = $this->denormalizer->denormalize(
                        $eventItem->players->out,
                        Model\Player::class,
                        $format,
                        $context
                    );
                    $eventObject->setPlayerOut($player);
                }

                $eventObjects[] = $eventObject;
            }
            $match->setEvents($eventObjects);
        }

        if (isset($data->penalty_shootout->kicks)) {
            /** @var Model\MatchProperties\Event\PenaltyShootoutKick[] $kickObjects */
            $kickObjects = [];
            $kickItems = $data->penalty_shootout->kicks;
            /** @var Model\MatchProperties\Event\PenaltyShootoutKick $kickObject */
            foreach ($kickItems as $kickItem) {
                $kickObject = Model\MatchProperties\MatchEvent::createEvent(
                    Model\MatchProperties\MatchEvent::EVENT_TYPE_PENALTY_SHOOTOUT_KICK
                );

                if (isset($kickItem->player)) {
                    /** @var Model\Player $player */
                    $player = $this->denormalizer->denormalize(
                        $kickItem->player,
                        Model\Player::class,
                        $format,
                        $context
                    );
                    $kickObject->setPlayer($player);
                }

                if (isset($kickItem->team)) {
                    /** @var Model\Team $team */
                    $team = $this->denormalizer->denormalize(
                        $kickItem->team,
                        Model\Team::class,
                        $format,
                        $context
                    );
                    $kickObject->setTeam($team);
                }

                if (isset($kickItem->missed) && $kickItem->missed) {
                    $kickObject->setMissed(true);
                }

                if (isset($kickItem->score[1])) {
                    $kickObject->setScore($kickItem->score[0], $kickItem->score[1]);
                }

                $kickObjects[] = $kickObject;
            }
            $match->setPenaltyShootoutKicks($kickObjects);
        }

        if (isset($data->season)) {
            /** @var Model\Season $season */
            $season = $this->denormalizer->denormalize($data->season, Model\Season::class, $format, $context);
            $match->setSeason($season);
        }

        if (isset($data->stage)) {
            /** @var Model\Stage $stage */
            $stage = $this->denormalizer->denormalize($data->stage, Model\Stage::class, $format, $context);
            $match->setStage($stage);
        }

        if (isset($data->context)) {
            $match->setContext(
                new ParameterBag(
                    (array)$data->context
                )
            );
        }

        return $match;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        if ($type != Model\Match::class) {
            return false;
        }

        return true;
    }

    /**
     * @param array $squadItems
     * @param String $format
     * @param array $context
     * @return Model\PlayerInSquad[]
     */
    private function processSquadItems(array $squadItems, $format, array $context)
    {
        $playersInSquad = [];
        if (is_array($squadItems)) {
            /** @var Model\PlayerInSquad[] $playersInSquad */
            foreach ($squadItems as $playerItem) {
                /** @var Model\Player $playerDenormalized */
                $playerDenormalized = $this->denormalizer->denormalize(
                    $playerItem,
                    Model\Player::class,
                    $format,
                    $context
                );

                $playerInSquad = new Model\PlayerInSquad();
                $playerInSquad->setPlayer($playerDenormalized);

                if (isset($playerItem->number)) {
                    $playerInSquad->setNumber($playerItem->number);
                }

                if (isset($playerItem->role)) {
                    $playerInSquad->setPosition($playerItem->role);
                }
                $playersInSquad[] = $playerInSquad;
            }
        }

        return $playersInSquad;
    }
}
