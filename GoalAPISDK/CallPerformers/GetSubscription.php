<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:31 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetSubscription extends CallPerformer
{
    public function loadDataFromProvider()
    {
        $response = $this->makeAPICall('');
        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Subscription
     */
    public function deserializeData($data)
    {
        /** @var Model\Subscription $subscription */
        $subscription = $this->serializer->deserialize($data, Model\Subscription::class, 'json');
        return $subscription;
    }

    public function mustRefresh()
    {
        return true;
    }
}
