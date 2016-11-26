<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\Core\CallPerformerInterface;

class GoalAPISDK extends Core\SDK
{

    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        parent::addCallPerformer($callName, $callPerformer);
    }
}