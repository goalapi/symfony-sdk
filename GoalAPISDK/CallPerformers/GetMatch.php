<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetMatch extends CallPerformer
{

    /**
     * @param Model\Tournament $tournament
     * @param Model\Season $season
     * @param Model\Stage $stage
     * @param String $matchId
     * @return String
     */
    public function loadDataFromProvider(
        Model\Tournament $tournament = null,
        Model\Season $season = null,
        Model\Stage $stage = null,
        $matchId = null
    ) {
        $ids = [
            $tournament->getId(),
            $season->getId(),
        ];
        if ($stage) {
            $ids[] = $stage->getId();
        }
        $url = self::pathFromIds($ids).'/matches/'.$matchId;

        $response = $this->apiClient->makeAPICall($url);

        return $response->getBody();
    }


    /**
     * @param $data
     * @return Model\Match
     */
    public function deserializeData($data)
    {
        /** @var Model\Match $match */
        $match = $this->serializer->deserialize($data, Model\Match::class, 'json');

        return $match;
    }


    public function mustRefresh()
    {
        return true;
    }
}