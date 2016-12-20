<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetSquad extends CallPerformer
{

    public function loadDataFromProvider(
        Model\Tournament $tournament = null,
        Model\Season $season = null,
        Model\Stage $stage = null,
        Model\Team $team = null
    ) {
        $tournamentId = $tournament->getId();
        $seasonId = $season->getId();

        if (0 === strpos($seasonId, $tournamentId.'.')) {
            $seasonId = substr($seasonId, strlen($tournamentId) + 1);
        }

        $url = '/tournaments/'.$tournamentId.'/seasons/'.$seasonId;

        if ($stage) {
            $stageId = $stage->getId();
            if (0 === strpos($stageId, $tournamentId.'.'.$seasonId)) {
                $stageId = substr($stageId, strlen($tournamentId.'.'.$seasonId) + 1);
            }
            $url = '/tournaments/'.$tournamentId.'/seasons/'.$seasonId.'/stage/'.$stageId;
        }
        $url .= '/teams/'.$team->getId();
        $response = $this->apiClient->makeAPICall($url);

        return $response->getBody();
    }


    /**
     * @param $data
     * @return Model\Squad
     */
    public function deserializeData($data)
    {
        /** @var Model\Squad $squad */
        $squad = $this->serializer->deserialize($data, Model\Squad::class, 'json');

        return $squad;
    }


    public function mustRefresh()
    {
        return true;
    }
}