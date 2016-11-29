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
        $apiClient = $this->getApiClient();
        $response = $apiClient->makeAPICall('');

        return $response->getData();
    }

    public function deserializeData($data)
    {
        $subscription = new Model\Subscription();
        $subscription->setStatus($data->status);
        $subscription->setExpirationTime(new \DateTime($data->expirationTime->date_time));

        if (isset($data->allowedTournaments)) {
            $tournamentObjects = [];
            foreach ($data->allowedTournaments as $tournamentItem) {
                $tournamentObject = new Model\Tournament();
                $tournamentObject->setId($tournamentItem->id);
                $tournamentObject->setName($tournamentItem->name);
                $tournamentObjects[] = $tournamentObject;
            }
            $subscription->setTournaments($tournamentObjects);
        }

        return $subscription;
    }

    public function mustRefresh()
    {
        return true;
    }
}
