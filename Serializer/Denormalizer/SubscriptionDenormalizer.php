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
    public function supportsDenormalization($data, $type, $format = null)
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
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $subscription = new Model\Subscription();
        $subscription->setStatus($data->status);
        $subscription->setExpirationTime(new \DateTime($data->expirationTime->date_time));

        if (isset($data->allowedTournaments)) {
            $tournamentObjects = [];
            foreach ($data->allowedTournaments as $tournamentItem) {
                $tournamentObject = $this->denormalizer->denormalize(
                    $tournamentItem,
                    Model\Tournament::class,
                    $format,
                    $context
                );
                $tournamentObjects[] = $tournamentObject;
            }
            $subscription->setTournaments($tournamentObjects);
        }

        return $subscription;
    }
}