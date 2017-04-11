<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetSquads extends CallPerformer
{

    public function performCall(array $arguments)
    {
        /** @var Model\Squad[] $squads */
        $squads = parent::performCall($arguments);
        foreach ($squads as &$squad) {
            $squad->setTournament($arguments[0]);
            $squad->setSeason($arguments[1]);
            if (isset($arguments[2])) {
                $squad->setStage($arguments[2]);
            }
        }

        return $squads;
    }

    public function loadDataFromProvider(
        Model\Tournament $tournament = null,
        Model\Season $season = null,
        Model\Stage $stage = null
    ) {
        $ids = [
            $tournament->getId(),
            $season->getId(),
        ];
        if ($stage) {
            $ids[] = $stage->getId();
        }
        $url = self::pathFromIds($ids).'/teams/';
        $response = $this->apiClient->makeAPICall($url);

        return $response->getBody();
    }


    /**
     * @param $data
     * @return Model\Squad[]
     */
    public function deserializeData($data)
    {
        /** @var Model\Squad[] $squad */
        $squad = $this->serializer->deserialize($data, Model\Squad::class.'[]', 'json');

        return $squad;
    }


    public function mustRefresh()
    {
        return true;
    }
}
