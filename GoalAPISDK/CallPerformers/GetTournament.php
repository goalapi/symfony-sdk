<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/5/16/7:18 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetTournament extends CallPerformer
{
    /**
     * @param string $tournamentId
     * @return string
     */
    public function loadDataFromProvider($tournamentId = null)
    {
        $response = $this->apiClient->makeAPICall('/tournaments/'.$tournamentId);

        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Tournament
     */
    public function deserializeData($data)
    {
        /** @var Model\Tournament $tournament */
        $tournament = $this->serializer->deserialize($data, Model\Tournament::class, 'json');

        return $tournament;
    }

    /**
     * @inheritdoc
     */
    public function mustRefresh()
    {
        return true;
    }
}