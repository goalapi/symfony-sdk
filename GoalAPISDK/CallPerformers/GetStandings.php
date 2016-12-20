<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetStandings extends CallPerformer
{
    public function loadDataFromProvider(
        Model\Tournament $tournament = null,
        Model\Season $season = null,
        Model\Stage $stage = null
    ) {
        $tournamentId = $tournament->getId();
        $seasonId = $season->getId();

        if (0 === strpos($seasonId, $tournamentId.'.')) {
            $seasonId = substr($seasonId, strlen($tournamentId) + 1);
        }

        $stageId = $stage->getId();
        if (0 === strpos($stageId, $tournamentId.'.'.$seasonId)) {
            $stageId = substr($stageId, strlen($tournamentId.'.'.$seasonId) + 1);
        }
        $url = '/tournaments/'.$tournamentId.'/seasons/'.$seasonId.'/stage/'.$stageId.'/standings/';

        $response = $this->apiClient->makeAPICall($url);

        return $response->getBody();
    }


    /**
     * @param $data
     * @return Model\StandingsTable[]
     */
    public function deserializeData($data)
    {
        /** @var Model\StandingsTable[] $standingsTables */
        $standingsTables = $this->serializer->deserialize($data, Model\StandingsTable::class.'[]', 'json');

        return $standingsTables;
    }

    public function mustRefresh()
    {
        return true;
    }
}
