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
        $ids = [
            $tournament->getId(),
            $season->getId(),
        ];
        if ($stage) {
            $ids[] = $stage->getId();
        }
        $url = self::pathFromIds($ids).'/teams/'.$team->getId();
        $response = $this->makeAPICall($url);

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
