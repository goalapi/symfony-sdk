<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/11:46 AM
 *
 */

namespace GoalAPI\SDKBundle\Serializer\Denormalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class SubscriptionDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    protected function checkObject($data, $type, $format = null)
    {
        if ($type != Model\Subscription::class) {
            return false;
        }
        if (!is_object($data)) {
            return false;
        }
        if (!isset($data->status)) {
            return false;
        }
        if (!isset($data->expirationTime->date_time)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    protected function processObject($data, $class, $format = null, array $context = array())
    {
        $subscription = new Model\Subscription();
        $subscription->setStatus($data->status);
        $subscription->setExpirationTime(new \DateTime($data->expirationTime->date_time));

        if (isset($data->allowedTournaments)) {
            $tournamentObjects = $this->denormalizer->denormalize(
                $data->allowedTournaments,
                Model\Tournament::class,
                $format,
                $context
            );
            $subscription->setTournaments($tournamentObjects);
        }
        return $subscription;
    }
}
