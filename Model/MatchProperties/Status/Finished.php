<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:19 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Status;

use GoalAPI\SDKBundle\Model;

class Finished extends Model\MatchProperties\MatchStatus
{

    /**
     * @var Model\MatchProperties\MatchMoment
     */
    private $lastMoment;

    public function __construct()
    {
        parent::__construct();
        $this->setStatus(self::STATUS_FINISHED);
        $this->setLastMoment(new Model\MatchProperties\MatchMoment());
    }

    /**
     * @return Model\MatchProperties\MatchMoment
     */
    public function getLastMoment()
    {
        return $this->lastMoment;
    }

    /**
     * @param Model\MatchProperties\MatchMoment $lastMoment
     */
    public function setLastMoment(Model\MatchProperties\MatchMoment $lastMoment)
    {
        $this->lastMoment = $lastMoment;
    }
}
