<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:22 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

use DateTime;
use GoalAPI\SDKBundle\Model\MatchProperties;
use Symfony\Component\HttpFoundation\ParameterBag;

class Match
{
    /**
     * @var String
     */
    private $id;

    /**
     * @var Team
     */
    private $hostsTeam;

    /**
     * @var Team
     */
    private $visitorsTeam;

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
     * @var MatchProperties\MatchStatus
     */
    private $status;

    /**
     * @var ParameterBag
     */
    private $context;

    /**
     * @var PlayerInSquad[]
     */
    private $hostsPlayers;

    /**
     * @var PlayerInSquad[]
     */
    private $visitorsPlayers;

    /**
     * @var PlayerInSquad[]
     */
    private $hostsSubstitutions;

    /**
     * @var PlayerInSquad[]
     */
    private $visitorsSubstitutions;

    /**
     * @var DateTime
     */
    private $beginTime;

    /**
     * @var MatchProperties\MatchEvent[]
     */
    private $events;

    /**
     * @var MatchProperties\Event\PenaltyShootoutKick[]
     */
    private $penaltyShootoutKicks;

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
    public function getHostsTeam()
    {
        return $this->hostsTeam;
    }

    /**
     * @param Team $hostsTeam
     */
    public function setHostsTeam(Team $hostsTeam)
    {
        $this->hostsTeam = $hostsTeam;
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
     * @return MatchProperties\MatchStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param MatchProperties\MatchStatus $status
     */
    public function setStatus(MatchProperties\MatchStatus $status)
    {
        $this->status = $status;
    }

    /**
     * @return ParameterBag
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param ParameterBag $context
     */
    public function setContext(ParameterBag $context)
    {
        $this->context = $context;
    }

    /**
     * @return Team
     */
    public function getVisitorsTeam()
    {
        return $this->visitorsTeam;
    }

    /**
     * @param Team $visitorsTeam
     */
    public function setVisitorsTeam(Team $visitorsTeam)
    {
        $this->visitorsTeam = $visitorsTeam;
    }

    /**
     * @return PlayerInSquad[]
     */
    public function getHostsPlayers()
    {
        return $this->hostsPlayers;
    }

    /**
     * @param PlayerInSquad[] $hostsPlayers
     */
    public function setHostsPlayers(array $hostsPlayers)
    {
        $this->hostsPlayers = $hostsPlayers;
    }

    /**
     * @return PlayerInSquad[]
     */
    public function getVisitorsPlayers()
    {
        return $this->visitorsPlayers;
    }

    /**
     * @param PlayerInSquad[] $visitorsPlayers
     */
    public function setVisitorsPlayers(array $visitorsPlayers)
    {
        $this->visitorsPlayers = $visitorsPlayers;
    }

    /**
     * @return PlayerInSquad[]
     */
    public function getVisitorsSubstitutions()
    {
        return $this->visitorsSubstitutions;
    }

    /**
     * @param PlayerInSquad[] $visitorsSubstitutions
     */
    public function setVisitorsSubstitutions(array $visitorsSubstitutions)
    {
        $this->visitorsSubstitutions = $visitorsSubstitutions;
    }

    /**
     * @return PlayerInSquad[]
     */
    public function getHostsSubstitutions()
    {
        return $this->hostsSubstitutions;
    }

    /**
     * @param PlayerInSquad[] $hostsSubstitutions
     */
    public function setHostsSubstitutions(array $hostsSubstitutions)
    {
        $this->hostsSubstitutions = $hostsSubstitutions;
    }

    /**
     * @return DateTime
     */
    public function getBeginTime()
    {
        return $this->beginTime;
    }

    /**
     * @param DateTime $beginTime
     */
    public function setBeginTime(DateTime $beginTime)
    {
        $this->beginTime = $beginTime;
    }

    /**
     * @return MatchProperties\MatchEvent[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param MatchProperties\MatchEvent[] $events
     */
    public function setEvents(array $events)
    {
        $this->events = $events;
    }

    /**
     * @return MatchProperties\Event\PenaltyShootoutKick[]
     */
    public function getPenaltyShootoutKicks()
    {
        return $this->penaltyShootoutKicks;
    }

    /**
     * @param MatchProperties\Event\PenaltyShootoutKick[] $penaltyShootoutKicks
     */
    public function setPenaltyShootoutKicks(array $penaltyShootoutKicks)
    {
        $this->penaltyShootoutKicks = $penaltyShootoutKicks;
    }
}
