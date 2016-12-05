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
use Symfony\Component\Serializer\Serializer;

/**
 * Class GoalAPISDK
 *
 * @method Model\Subscription getSubscription
 */
class GoalAPISDK extends SDK implements APIClient\APIClientAwareInterface
{
    use APIClient\APIClientAwareTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param string $callName
     * @param CallPerformerInterface $callPerformer
     */
    function addCallPerformer($callName, CallPerformerInterface $callPerformer)
    {
        if ($callPerformer instanceof APIClient\APIClientAwareInterface) {
            $this->injectAPIClient($callPerformer);
        }
        parent::addCallPerformer($callName, $callPerformer);
    }


    private function injectAPIClient(APIClient\APIClientAwareInterface $receiver)
    {
        try {
            $apiClient = $this->getApiClient();
            $receiver->setAPIClient($apiClient);
        } catch (\RuntimeException $x) {
        }
    }

    /**
     * @param Serializer $serializer
     */
    public function setSerializer(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

}
