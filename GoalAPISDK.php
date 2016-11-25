<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\Core\CallPerformerInterface;
use GoalAPI\SDKBundle\Core\Persister;

class GoalAPISDK extends Core\SDK
    implements Persister\PersisterAwareInterface
{
    use Persister\PersisterAwareTrait;

    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        if ($this->persister && $callPerformer instanceof Persister\PersisterAwareTrait) {
            $callPerformer->setPersister($this->persister);
        }
        parent::addCallPerformer($callName, $callPerformer);
    }
}