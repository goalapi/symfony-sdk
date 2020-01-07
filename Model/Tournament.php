<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:17 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Tournament
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Territory
     */
    private $coverage;

    /**
     * @var string
     */
    private $teamsType;

    /**
     * @var Season
     */
    private $activeSeason;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Territory
     */
    public function getCoverage()
    {
        return $this->coverage;
    }

    /**
     * @param Territory $coverage
     */
    public function setCoverage($coverage)
    {
        $this->coverage = $coverage;
    }

    /**
     * @return string
     */
    public function getTeamsType()
    {
        return $this->teamsType;
    }

    /**
     * @param string $teamsType
     */
    public function setTeamsType($teamsType)
    {
        $this->teamsType = $teamsType;
    }

    /**
     * @return Season
     */
    public function getActiveSeason()
    {
        return $this->activeSeason;
    }

    /**
     * @param Season $activeSeason
     */
    public function setActiveSeason(Season $activeSeason)
    {
        $this->activeSeason = $activeSeason;
    }
}
