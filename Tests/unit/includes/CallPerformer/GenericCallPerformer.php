<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 2:38 PM
 */

namespace GoalAPI\SDKBundle\Tests\unit\includes\CallPerformer;

use GoalAPI\SDKBundle\SDK\CallPerformerInterface;

class GenericCallPerformer implements CallPerformerInterface
{
    function performCall(array $arguments)
    {
        return $arguments;
    }
}
