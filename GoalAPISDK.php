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
        try {
            $receiver->setAPIClient($this->apiClient);
        } catch (\RuntimeException $x) {
        }
    }

    private function injectSerializer(Serializer\SerializerAwareInterface $receiver)
    {
        if ($this->serializer) {
            $receiver->setSerializer($this->serializer);
        }
    }
}

