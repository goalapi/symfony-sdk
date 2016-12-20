<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:19 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Status;

use GoalAPI\SDKBundle\Model;

class Online extends Model\MatchProperties\MatchStatus
{

    /**
     * @var Model\MatchProperties\MatchMoment
     */
    private $currentMoment;

    public function __construct()
    {
        parent::__construct();
        $this->setStatus(self::STATUS_ONLINE);
        $this->setCurrentMoment(new Model\MatchProperties\MatchMoment());
    }

    /**
     * @return Model\MatchProperties\MatchMoment
     */
    public function getCurrentMoment()
    {
        return $this->currentMoment;
    }

    /**
     * @param Model\MatchProperties\MatchMoment $currentMoment
     */
    public function setCurrentMoment(Model\MatchProperties\MatchMoment $currentMoment)
    {
        $this->currentMoment = $currentMoment;
    }
}
