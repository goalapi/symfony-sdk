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
    protected $data;

    /**
     * GoalAPISDKEvent constructor.
     *
     * @param mixed $data
     * @param array $arguments
     */
    public function __construct($data, array $arguments = [])
    {

        $this->setData($data);
        $this->setArguments($arguments);
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
