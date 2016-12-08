<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/12:26 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class SeasonDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object, $type, $format = null)
    {
        if ($type != Model\Season::class) {
            return false;
        }
        if (!is_object($object)) {
            return false;
        }
        if (!isset($object->name)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     * @return Model\Season
     */
    public function denormalize($object, $class, $format = null, array $context = array())
    {
        $season = new Model\Season();
        if (isset($object->_links->self)) {
            $link = $object->_links->self->href;
            $link = trim($link, '/');
            $link = explode('/', $link);
            $season->setId($link[1].'.'.$link[3]);
        }
        $season->setName($object->name);

        return $season;
    }
}
