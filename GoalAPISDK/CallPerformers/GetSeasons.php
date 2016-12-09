<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetSeasons extends CallPerformer
{
    /**
     * @param Model\Tournament $tournament
     * @return string
     */
    public function loadDataFromProvider(Model\Tournament $tournament = null)
    {
        $response = $this->apiClient->makeAPICall('/tournaments/'.$tournament->getId().'/seasons/');

        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Season[]
     */
    public function deserializeData($data)
    {
        /** @var Model\Season[] $seasons */
        $seasons = $this->serializer->deserialize($data, Model\Season::class.'[]', 'json');

        return $seasons;
    }

    /**
     * @inheritdoc
     */
    public function mustRefresh()
    {
        return true;
    }
}
