<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:21 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Stage
{
    /**
     * @var String
     */
    private $id;

    /**
     * @var String
     */
    private $name;

    /**
     * @var Tournament
     */
    private $tournament;

    /**
     * @var Season
     */
    private $season;

    /**
     * @var bool
     */
    private $hasStandings;

    /**
     * @return String
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * @param Season $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }

    /**
     * @return bool
     */
    public function hasStandings()
    {
        return $this->hasStandings;
    }

    /**
     * @param bool $hasStandings
     */
    public function setHasStandings($hasStandings)
    {
        $this->hasStandings = $hasStandings;
    }
}
