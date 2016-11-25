<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 3:24 PM
 */

namespace GoalAPI\SDKBundle\Core;

class SDK
{
    /**
     * @var CallPerformerInterface[]
     */
    private $callPerformers;

    function __call($name, $arguments)
    {
        return $this->makeCall($name, $arguments);
    }

    /**
     * Makes call with one of registered Call Performers
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function makeCall($name, $arguments)
    {
        if (!isset($this->callPerformers[$name])) {
            throw new \BadMethodCallException();
        }
        /** @var CallPerformerInterface $callPerformer */
        $callPerformer = $this->callPerformers[$name];

        return $callPerformer->performCall($arguments);
    }

    /**
     * @param CallPerformerInterface[] $callPerformers
     */
    public function setCallPerformers(array $callPerformers)
    {
        $this->callPerformers = [];
        /** @var CallPerformerInterface $performer */
        foreach ($callPerformers as $callName => $performer) {
            $this->addCallPerformer($callName, $performer);
        }
    }

    /**
     * @param string $callName
     * @param CallPerformerInterface $callPerformer
     */
    public function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        $this->callPerformers[$callName] = $callPerformer;
    }
}