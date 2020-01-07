<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:25 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

use Symfony\Component\HttpFoundation\ParameterBag;

class StandingsTable
{
    /**
     * @var String
     */
    private $id;

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
     * @var ParameterBag
     */
    private $context;

    /**
     * @var StandingsTableRow[]
     */
    private $rows;


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
     * @return Stage
     */
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * @param Stage $stage
     */
    public function setStage($stage)
    {
        $this->stage = $stage;
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
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return StandingsTableRow[]
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param StandingsTableRow[] $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
}
