<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetSeason extends CallPerformer
{
    /**
     * @param Model\Tournament $tournament
     * @param string $seasonId
     * @return string
     */
    public function loadDataFromProvider(Model\Tournament $tournament = null, $seasonId = null)
    {
        $tournamentId = $tournament->getId();
        if (0 === strpos($seasonId, $tournamentId.'.')) {
            $seasonId = substr($seasonId, strlen($tournamentId) + 1);
        }
        $response = $this->apiClient->makeAPICall(
            'tournaments/'.$tournamentId.'/seasons/'.$seasonId
        );

        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Season
     */
    public function deserializeData($data)
    {
        /** @var Model\Season $season */
        $season = $this->serializer->deserialize($data, Model\Season::class, 'json');

        return $season;
    }

    /**
     * @inheritdoc
     */
    public function mustRefresh()
    {
        return true;
    }
}
