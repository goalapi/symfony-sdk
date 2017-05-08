<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 5/8/17/12:04 PM
 *
 */

namespace GoalAPI\SDKBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

trait EventDispatcherAwareTrait
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
}
