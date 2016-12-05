<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/1:44 PM
 *
 */

namespace GoalAPI\SDKBundle\SDK;

interface CallPerformerInterface
{
    /**
     * This method contains behavior which should be implemented by this Call Performer
     *
     * @param array $arguments
     * @return mixed
     */
    function performCall(array $arguments);
}