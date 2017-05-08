<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 5/8/17/12:23 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\EventDispatcher\Event;

use Symfony\Component\EventDispatcher\Event;

class GoalAPISDKEvent extends Event
{
    const LOAD = 'goalapi.load';

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @var mixed
     */
    protected $result;
    /**
     * @var
     */
    private $callName;

    /**
     * GoalAPISDKEvent constructor.
     * @param array $arguments
     * @param $result
     */
    public function __construct($callName, array $arguments, $result)
    {

        $this->setResult($result);
        $this->setArguments($arguments);
        $this->setCallName($callName);
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getCallName()
    {
        return $this->callName;
    }

    /**
     * @param mixed $callName
     */
    public function setCallName($callName)
    {
        $this->callName = $callName;
    }
}
