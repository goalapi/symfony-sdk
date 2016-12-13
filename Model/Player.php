<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/11/16/9:29 AM
 *
 */

namespace GoalAPI\SDKBundle\Model;

use Symfony\Component\HttpFoundation\ParameterBag;

class Player
{
    const PLAYER_POSITION_GOALKEEPER = 'goalkeeper';
    const PLAYER_POSITION_DEFENDER = 'defender';
    const PLAYER_POSITION_MIDFIELDER = 'midfielder';
    const PLAYER_POSITION_FORWARD = 'forward';

    /**
     * @var String
     */
    private $id;

    /**
     * @var String
     */
    private $name;

    /**
     * @var ParameterBag
     */
    private $names;

    /**
     * @var ParameterBag
     */
    private $bio;

    /**
     * @var String
     */
    private $position;

    /**
     * @var Territory
     */
    private $country;

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
     * @return ParameterBag
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param ParameterBag $names
     */
    public function setNames($names)
    {
        $this->names = $names;
    }

    /**
     * @return ParameterBag
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * @param ParameterBag $bio
     */
    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    /**
     * @return String
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param String $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Territory
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Territory $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
