<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/5/16/7:18 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetTournaments extends CallPerformer
{
    /**
     * @inheritdoc
     */
    public function loadDataFromProvider()
    {
        $response = $this->apiClient->makeAPICall('/tournaments/');

        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Tournament
     */
    public function deserializeData($data)
    {
        /** @var Model\Tournament $tournaments */
        $tournaments = $this->serializer->deserialize($data, Model\Tournament::class, 'json');

        return $tournaments;
    }

    /**
     * @inheritdoc
     */
    public function mustRefresh()
    {
        return true;
    }
}