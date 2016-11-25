<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\Core\APIClient;
use GoalAPI\SDKBundle\Core\CallPerformerInterface;
use GoalAPI\SDKBundle\Core\Persister;

class GoalAPISDK extends Core\SDK
    implements Persister\PersisterAwareInterface,
    APIClient\APIClientAwareInterface
{
    use Persister\PersisterAwareTrait;
    use APIClient\APIClientAwareTrait;

    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        if ($this->persister && $callPerformer instanceof Persister\PersisterAwareTrait) {
            $callPerformer->setPersister($this->persister);
        }
        if ($this->client && $callPerformer instanceof APIClient\APIClientAwareInterface) {
            $callPerformer->setAPIClient($this->client);
        }
        parent::addCallPerformer($callName, $callPerformer);
    }
}