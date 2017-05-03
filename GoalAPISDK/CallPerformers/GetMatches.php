<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/20/16/10:02 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;

class GetMatches extends CallPerformer
{

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
        $url = self::pathFromIds($ids).'/matches/';
        $response = $this->apiClient->makeAPICall($url);

        $body = strval($response->getBody());

        while ($response->hasLinks() && $nextLink = $response->getLink('next')) {
            $body = trim($body, '[]');
            $response = $this->apiClient->makeAPICall($nextLink);
            $linkBody = $response->getBody();
            $linkBody = trim($linkBody, '[]');
            $body .= ', '.$linkBody;
            $body = '['.$body.']';
        }

        return $body;
    }


    /**
     * @param $data
     * @return Model\Match[]
     */
    public function deserializeData($data)
    {
        /** @var Model\Match[] $matches */
        $matches = $this->serializer->deserialize($data, Model\Match::class.'[]', 'json');

        return $matches;
    }


    public function mustRefresh()
    {
        return true;
    }
}