<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:19 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Status;

use GoalAPI\SDKBundle\Model;

class Abnormal extends Model\MatchProperties\MatchStatus
{

    /**
     * @var Model\MatchProperties\MatchMoment
     */
    private $currentMoment;

    public function __construct()
    {
        parent::__construct();
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
