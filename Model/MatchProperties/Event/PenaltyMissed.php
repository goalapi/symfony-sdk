<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Event;

use GoalAPI\SDKBundle\Model;

class PenaltyMissed extends Model\MatchProperties\MatchEvent
{
    /**
     * @var Model\Player
     */
    private $player;


    public function __construct()
    {
        $this->setType(Model\MatchProperties\MatchEvent::EVENT_TYPE_PENALTY_MISSED);
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
}
