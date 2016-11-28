<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:16 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Subscription
{
    /**
     * @var String
     */
    private $status;

    /**
     * @var \DateTime
     */
    private $expirationTime;

    /**
     * @var Tournament[]
     */
    private $tournaments;

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
     * @return \DateTime
     */
    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @param \DateTime $expirationTime
     */
    public function setExpirationTime($expirationTime)
    {
        $this->expirationTime = $expirationTime;
    }

    /**
     * @return Tournament[]
     */
    public function getTournaments()
    {
        return $this->tournaments;
    }

    /**
     * @param Tournament[] $tournaments
     */
    public function setTournaments($tournaments)
    {
        $this->tournaments = $tournaments;
    }
}
