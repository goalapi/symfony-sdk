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
use GoalAPI\SDKBundle\Core\RefreshTimeRegistry;

class GoalAPISDK extends Core\SDK
    implements Persister\PersisterAwareInterface,
    APIClient\APIClientAwareInterface,
    RefreshTimeRegistry\RefreshTimeRegistryAwareInterface
{
    use Persister\PersisterAwareTrait;
    use APIClient\APIClientAwareTrait;
    use RefreshTimeRegistry\RefreshTimeRegistryAwareTrait;

    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        if ($this->persister && $callPerformer instanceof Persister\PersisterAwareTrait) {
            $callPerformer->setPersister($this->persister);
        }
        if ($this->client && $callPerformer instanceof APIClient\APIClientAwareInterface) {
            $callPerformer->setAPIClient($this->client);
        }
        if ($this->refreshTimeRegistry && $callPerformer instanceof RefreshTimeRegistry\RefreshTimeRegistryAwareInterface) {
            $callPerformer->setRefreshTimeRegistry($this->refreshTimeRegistry);
        }
        parent::addCallPerformer($callName, $callPerformer);
    }
}