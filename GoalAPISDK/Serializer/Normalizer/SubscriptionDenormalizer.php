<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/11:46 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class SubscriptionDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object, $type, $format = null)
    {
        if ($type != Model\Subscription::class) {
            return false;
        }
        if (!is_object($object)) {
            return false;
        }
        if (!isset($object->status)) {
            return false;
        }
        if (!isset($object->expirationTime->date_time)) {
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     * @return Model\Subscription
     */
    public function denormalize($object, $class, $format = null, array $context = array())
    {
        $subscription = new Model\Subscription();
        $subscription->setStatus($object->status);
        $subscription->setExpirationTime(new \DateTime($object->expirationTime->date_time));

        if (isset($object->allowedTournaments)) {
            /** @var Model\Tournament[] $tournamentObjects */
            $tournamentObjects = $this->denormalizer->denormalize(
                $object->allowedTournaments,
                Model\Tournament::class.'[]',
                $format,
                $context
            );
            $subscription->setTournaments($tournamentObjects);
        }
        return $subscription;
    }
}
