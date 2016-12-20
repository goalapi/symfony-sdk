<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:27 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Squad
{
    /**
     * @var String
     */
    private $id;

    /**
     * @var Team
     */
    private $team;

    /**
     * @var Tournament
     */
    private $tournament;

    /**
     * @var Season
     */
    private $season;

    /**
     * @var Stage
     */
    private $stage;

    /**
     * @var PlayerInSquad[]
     */
    private $players;


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
     * @return Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param Team $team
     */
    public function setTeam(Team $team)
    {
        $this->team = $team;
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
    public function setTournament(Tournament $tournament)
    {
        $this->tournament = $tournament;
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
    public function setSeason(Season $season)
    {
        $this->season = $season;
    }

    /**
     * @return Stage
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param Stage $stage
     */
    public function setStage(Stage $stage)
    {
        $this->stage = $stage;
    }

    /**
     * @return PlayerInSquad[]
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param PlayerInSquad[] $players
     */
    public function setPlayers(array $players)
    {
        $this->players = $players;
    }
}
