<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Event;

use GoalAPI\SDKBundle\Model;

class PenaltyShootoutKick extends Model\MatchProperties\MatchEvent
{
    /**
     * @var Model\Player
     */
    private $player;

    /**
     * @var bool
     */
    private $missed;

    /**
     * @var array
     */
    private $score = [0, 0];


    public function __construct()
    {
        $this->setType(Model\MatchProperties\MatchEvent::EVENT_TYPE_PENALTY_SHOOTOUT_KICK);
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
    public function isMissed()
    {
        return $this->missed;
    }

    /**
     * @param bool $missed
     */
    public function setMissed($missed)
    {
        $this->missed = $missed;
    }

    /**
     * @return array
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param int $score1
     * @param int $score2
     */
    public function setScore($score1, $score2)
    {
        $this->score = [$score1, $score2];
    }
}
