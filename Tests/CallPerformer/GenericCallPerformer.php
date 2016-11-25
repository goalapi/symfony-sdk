<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 2:38 PM
 */

namespace GoalAPI\SDKBundle\Tests\CallPerformer;

use GoalAPI\SDKBundle\Core\CallPerformerInterface;

class GenericCallPerformer implements CallPerformerInterface
{
    function performCall(array $arguments)
    {
        return $arguments;
    }
}