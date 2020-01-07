<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:22 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

use Symfony\Component\HttpFoundation\ParameterBag;

class Team
{
    const TYPE_CLUB = 'club';
    const TYPE_NATIONAL = 'national';
    const TYPE_GENERIC = 'generic';

    /**
     * @var String
     */
    private $id;

    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $type;

    /**
     * @var ParameterBag
     */
    private $names;

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
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param String $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
