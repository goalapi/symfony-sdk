<?php declare(strict_types=1);
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
        $url = self::pathFromIds([$tournament->getId(), $season->getId(), $stage->getId()]).'/standings/';
        $response = $this->makeAPICall($url);

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
