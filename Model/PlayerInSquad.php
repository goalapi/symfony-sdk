<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/12/16/6:35 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class PlayerInSquad
{
    /**
     * @var Player
     */
    private $player;

    /**
     * @var String
     */
    private $number;

    /**
     * @var String
     */
    private $position;

    /**
     * @return String
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param String $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param Player $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return String
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param String $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
}
