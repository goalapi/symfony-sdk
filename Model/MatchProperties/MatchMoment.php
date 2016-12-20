<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/2:40 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties;

class MatchMoment
{

    const MATCH_PERIOD_FIRST_HALF = '1T';
    const MATCH_PERIOD_SECOND_HALF = '2T';
    const MATCH_PERIOD_HALF_TIME_BREAK = 'HT';
    const MATCH_PERIOD_EXTRA_TIME = 'ET';
    const MATCH_PERIOD_EXTRA_TIME_FIRST_HALF = 'E1T';
    const MATCH_PERIOD_EXTRA_TIME_SECOND_HALF = 'E2T';
    const MATCH_PERIOD_EXTRA_TIME_BREAK = 'EHT';
    const MATCH_PERIOD_PENALTY_SHOOTOUT = 'PS';

    /**
     * @var String
     */
    private $period;

    /**
     * @var int
     */
    private $minute;

    /**
     * @param String $period
     * @param int $minute
     * @return MatchMoment
     */
    static public function createInstance($period, $minute = null)
    {
        $matchMoment = new MatchMoment();
        $matchMoment->setPeriod($period);
        if (!is_null($minute)) {
            $matchMoment->setMinute($minute);
        }

        return $matchMoment;
    }

    /**
     * @return String
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param String $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param int $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
    }
}
