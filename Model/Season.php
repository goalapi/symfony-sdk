<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:18 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Season
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
     * @var Tournament
     */
    private $tournament;

    /**
     * @var Stage[]
     */
    private $stages;


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
     * @return Stage[]
     */
    public function getStages()
    {
        return $this->stages;
    }

    /**
     * @param Stage[] $stages
     */
    public function setStages(array $stages)
    {
        $this->stages = $stages;
    }
}