<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

class GoalAPISDK
{
    /**
     * @var Core\CallPerformerInterface[]
     */
    private $callPerformers;


    function __call($name, $arguments)
    {
        return $this->makeCall($name, $arguments);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function makeCall($name, $arguments)
    {
        if (!isset($this->callPerformers[$name])) {
            throw new \BadMethodCallException();
        }
        /** @var Core\CallPerformerInterface $callPerformer */
        $callPerformer = $this->callPerformers[$name];

        return $callPerformer->performCall($arguments);
    }

    /**
     * @param Core\CallPerformerInterface[] $callPerformers
     */
    public function setCallPerformers(array $callPerformers)
    {
        $this->callPerformers = [];
        /** @var Core\CallPerformerInterface $performer */
        foreach ($callPerformers as $callName => $performer) {
            $this->addCallPerformer($callName, $performer);
        }
    }

    /**
     * @param string $callName
     * @param Core\CallPerformerInterface $callPerformer
     */
    public function addCallPerformer($callName, Core\CallPerformerInterface $callPerformer)
    {
        $this->callPerformers[$callName] = $callPerformer;
    }

}