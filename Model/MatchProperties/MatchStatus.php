<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/2:40 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties;

use GoalAPI\SDKBundle\Model;
use InvalidArgumentException;

abstract class MatchStatus
{
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_ONLINE = 'online';
    const STATUS_FINISHED = 'finished';
    const STATUS_POSTPONED = 'postponed';
    const STATUS_INTERRUPTED = 'interrupted';
    const STATUS_CANCELED = 'canceled';

    /**
     * @param $statusType
     * @return MatchStatus
     */
    public static function createInstance($statusType)
    {
        $matchStatus = null;
        switch ($statusType) {
            case self::STATUS_SCHEDULED:
                $matchStatus = new Model\MatchProperties\Status\Scheduled();
                break;

            case self::STATUS_ONLINE:
                $matchStatus = new Model\MatchProperties\Status\Online();
                break;

            case self::STATUS_FINISHED:
                $matchStatus = new Model\MatchProperties\Status\Finished();
                break;

            case self::STATUS_POSTPONED:
            case self::STATUS_INTERRUPTED:
            case self::STATUS_CANCELED:
                $matchStatus = new Model\MatchProperties\Status\Abnormal();
                $matchStatus->setStatus($statusType);
                break;
        }

        if (is_null($matchStatus)) {
            throw  new InvalidArgumentException('Undefined match status type: '.$statusType);
        }

        return $matchStatus;
    }

    /**
     * @var String
     */
    protected $status;

    /**
     * @var array
     */
    protected $score;

    public function __construct()
    {
        $this->setScore(0, 0);
    }

    /**
     * @return String
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param String $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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