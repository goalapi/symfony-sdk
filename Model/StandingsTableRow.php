<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/11:42 AM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class StandingsTableRow
{
    /**
     * @var Team
     */
    private $team;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $points;

    /**
     * @var object
     */
    private $matches;

    /**
     * @var object
     */
    private $goals;

    /**
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return object
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param object|array $matches
     */
    public function setMatches($matches)
    {
        $this->matches = (object)$matches;
    }

    /**
     * @return object
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * @param object|array $goals
     */
    public function setGoals($goals)
    {
        $this->goals = (object)$goals;
    }
}
