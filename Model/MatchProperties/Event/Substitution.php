<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Event;

use GoalAPI\SDKBundle\Model;

class Substitution extends Model\MatchProperties\MatchEvent
{
    /**
     * @var Model\Player
     */
    private $playerIn;

    /**
     * @var Model\Player
     */
    private $playerOut;


    public function __construct()
    {
        $this->setType(Model\MatchProperties\MatchEvent::EVENT_TYPE_SUBSTITUTION);
    }

    /**
     * @return Model\Player
     */
    public function getPlayerIn()
    {
        return $this->playerIn;
    }

    /**
     * @param Model\Player $playerIn
     */
    public function setPlayerIn($playerIn)
    {
        $this->playerIn = $playerIn;
    }

    /**
     * @return Model\Player
     */
    public function getPlayerOut()
    {
        return $this->playerOut;
    }

    /**
     * @param Model\Player $playerOut
     */
    public function setPlayerOut($playerOut)
    {
        $this->playerOut = $playerOut;
    }
}
