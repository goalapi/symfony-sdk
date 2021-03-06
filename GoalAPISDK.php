<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\APIClient;
use GoalAPI\SDKBundle\EventDispatcher;
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
 * @method Model\Stage getStage(Model\Tournament $tournament, Model\Season $season, String $stageId)
 * @method Model\Match[] getMatches(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage = null)
 * @method Model\Match getMatch(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage, String $matchId)
 * @method Model\Squad[] getSquads(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage = null)
 * @method Model\Squad getSquad(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage, Model\Team $team)
 * @method Model\StandingsTable[] getStandings(Model\Tournament $tournament, Model\Season $season, Model\Stage $stage)
 */
class GoalAPISDK extends SDK implements APIClient\APIClientAwareInterface, Serializer\SerializerAwareInterface, EventDispatcher\EventDispatcherAwareInterface
{
    use APIClient\APIClientAwareTrait;
    use Serializer\SerializerAwareTrait;
    use EventDispatcher\EventDispatcherAwareTrait;

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
        if ($callPerformer instanceof EventDispatcher\EventDispatcherAwareInterface) {
            $this->injectEventDispatcher($callPerformer);
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

    private function injectEventDispatcher(EventDispatcher\EventDispatcherAwareInterface $receiver)
    {
        if ($this->eventDispatcher) {
            $receiver->setEventDispatcher($this->eventDispatcher);
        }
    }
}
