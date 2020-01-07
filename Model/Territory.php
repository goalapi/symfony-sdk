<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/7/16/11:31 PM
 *
 */

namespace GoalAPI\SDKBundle\Model;

class Territory
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
    private $parent;

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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Territory $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}