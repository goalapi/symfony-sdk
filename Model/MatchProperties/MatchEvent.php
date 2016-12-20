<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/2:40 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties;

use GoalAPI\SDKBundle\Model;

abstract class MatchEvent
{

    const EVENT_TYPE_GOAL = 'goal';
    const EVENT_TYPE_CARD = 'card';
    const EVENT_TYPE_PENALTY_MISSED = 'penalty_missed';
    const EVENT_TYPE_PENALTY_SHOOTOUT_KICK = 'penalty_shootout_kick';
    const EVENT_TYPE_SUBSTITUTION = 'substitution';

    /**
     * @param String $eventType
     * @return MatchEvent
     */
    public static function createEvent($eventType)
    {
        $event = null;
        switch ($eventType) {
            case self::EVENT_TYPE_GOAL:
                $event = new Model\MatchProperties\Event\Goal();
                break;

            case self::EVENT_TYPE_CARD:
                $event = new Model\MatchProperties\Event\Card();
                break;

            case self::EVENT_TYPE_SUBSTITUTION:
                $event = new Model\MatchProperties\Event\Substitution();
                break;

            case self::EVENT_TYPE_PENALTY_MISSED:
                $event = new Model\MatchProperties\Event\PenaltyMissed();
                break;

            case self::EVENT_TYPE_PENALTY_SHOOTOUT_KICK:
                $event = new Model\MatchProperties\Event\PenaltyShootoutKick();
                break;
        }

        if (is_null($event)) {
            throw  new \InvalidArgumentException('Undefined match status type: '.$eventType);
        }

        return $event;
    }

    /**
     * @var Model\Team
     */
    protected $team;

    /**
     * @var MatchMoment
     */
    protected $moment;

    /**
     * @var String
     */
    protected $type;

    /**
     * @return Model\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Model\Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return MatchMoment
     */
    public function getMoment()
    {
        return $this->moment;
    }

    /**
     * @param MatchMoment $moment
     */
    public function setMoment($moment)
    {
        $this->moment = $moment;
    }

    /**
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
