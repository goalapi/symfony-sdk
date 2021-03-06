<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/9/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetStages extends CallPerformer
{
    /**
     * @param Model\Tournament $tournament
     * @return string
     */
    public function loadDataFromProvider(Model\Tournament $tournament = null, Model\Season $season = null)
    {
        $path = CallPerformer::pathFromIds([$tournament->getId(), $season->getId()]);
        $response = $this->makeAPICall($path.'/stages/');

        return $response->getBody();
    }

    /**
     * @param $data
     * @return Model\Season[]
     */
    public function deserializeData($data)
    {
        /** @var Model\Season[] $seasons */
        $seasons = $this->serializer->deserialize($data, Model\Stage::class.'[]', 'json');

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
