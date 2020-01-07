<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/7/16/11:58 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class TerritoryDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object,string $type, string $format = null)
    {
        if ($type != Model\Territory::class) {
            return false;
        }
        if (!is_object($object)) {
            return false;
        }
        if (!isset($object->id)) {
            return false;
        }
        if (!isset($object->name)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     * @return Model\Territory
     */
    public function denormalize($object,string $class, string $format = null, array $context = array())
    {
        $territory = new Model\Territory();
        $territory->setId($object->id);
        if (isset($object->name)) {
            $territory->setName($object->name);
        }
        if (isset($object->parent) && $this->supportsDenormalization($object->parent, $class, $format)) {
            $territory->setParent($this->denormalize($object->parent, $class, $format, $context));
        }

        return $territory;
    }
}
