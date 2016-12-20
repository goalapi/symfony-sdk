<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\APIClient;
use GoalAPI\SDKBundle\SDK\CallPerformerInterface;
use GoalAPI\SDKBundle\SDK\SDK;
use Symfony\Component\Serializer;

/**
 * Class GoalAPISDK
 *
 * @method Model\Subscription getSubscription
 * @method Model\Tournament[] getTournaments
 * @method Model\Tournament getTournament(String $tournamentId)
 * @method Model\Season[] getSeasons(Model\Tournament $tournament)
 * @method Model\Season getSeason(Model\Tournament $tournament, String $seasonId)
 * @method Model\Stage[] getStages(Model\Tournament $tournament, Model\Season $season)
 * @method Model\Match[] getMatches(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage = null)
 * @method Model\Match getMatch(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage = null, String $matchId)
 * @method Model\Squad[] getSquads(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage = null)
 */
class GoalAPISDK extends SDK implements APIClient\APIClientAwareInterface, Serializer\SerializerAwareInterface
{
    use APIClient\APIClientAwareTrait;
    use Serializer\SerializerAwareTrait;

    /**
     * @param string $callName
     * @param CallPerformerInterface $callPerformer
     */
    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        if ($callPerformer instanceof APIClient\APIClientAwareInterface) {
            $this->injectAPIClient($callPerformer);
        }
        if ($callPerformer instanceof Serializer\SerializerAwareInterface) {
            $this->injectSerializer($callPerformer);
        }
        parent::addCallPerformer($callName, $callPerformer);
    }


    private function injectAPIClient(APIClient\APIClientAwareInterface $receiver)
    {
        if ($this->apiClient) {
            $receiver->setAPIClient($this->apiClient);
        }
    }

    private function injectSerializer(Serializer\SerializerAwareInterface $receiver)
    {
        if ($this->serializer) {
            $receiver->setSerializer($this->serializer);
        }
    }
}
