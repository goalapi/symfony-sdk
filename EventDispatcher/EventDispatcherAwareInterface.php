<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 5/8/17/12:08 PM
 *
 */

namespace GoalAPI\SDKBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

interface EventDispatcherAwareInterface
{
    public function setEventDispatcher(EventDispatcherInterface $eventDispatcher);
}