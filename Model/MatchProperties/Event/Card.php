<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Event;

use GoalAPI\SDKBundle\Model;

class Card extends Model\MatchProperties\MatchEvent
{
    const CARD_COLOR_YELLOW = 'yellow';
    const CARD_COLOR_RED = 'red';
    const CARD_COLOR_YELLOWRED = 'yellow_red';

    /**
     * @var Model\Player
     */
    private $player;

    /**
     * @var String
     */
    private $color;


    public function __construct()
    {
        $this->setType(Model\MatchProperties\MatchEvent::EVENT_TYPE_CARD);
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
     * @return String
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param String $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
}
