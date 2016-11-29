<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/12:26 PM
 *
 */

namespace GoalAPI\SDKBundle;

use GoalAPI\SDKBundle\Core\APIClient;
use GoalAPI\SDKBundle\Core\CallPerformerInterface;

/**
 * Class GoalAPISDK
 *
 * @method Model\Subscription getSubscription
 */
class GoalAPISDK extends Core\SDK implements APIClient\APIClientAwareInterface
{
    use APIClient\APIClientAwareTrait;

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

}
