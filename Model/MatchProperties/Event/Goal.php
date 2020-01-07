<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Event;

use GoalAPI\SDKBundle\Model;

class Goal extends Model\MatchProperties\MatchEvent
{
    /**
     * @var Model\Player
     */
    private $player;

    /**
     * @var bool
     */
    private $ownGoal;

    /**
     * @var bool
     */
    private $penalty;


    public function __construct()
    {
        $this->setType(Model\MatchProperties\MatchEvent::EVENT_TYPE_GOAL);
    }

    /**
     * @return Model\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Model\Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return bool
     */
    public function isOwnGoal()
    {
        return $this->ownGoal;
    }

    /**
     * @param bool $ownGoal
     */
    public function setOwnGoal($ownGoal)
    {
        $this->ownGoal = $ownGoal;
    }

    /**
     * @return bool
     */
    public function isPenalty()
    {
        return $this->penalty;
    }

    /**
     * @param bool $penalty
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    }
}
