<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/10:30 PM
 *
 */

namespace GoalAPI\SDKBundle\Serializer\Denormalizer;

use GoalAPI\SDKBundle\Serializer\Denormalizer;

class ArrayDenormalizer extends Denormalizer
{
    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if (!is_array($data)) {
            return false;
        }
        if ('[]' != substr($type, -2)) {
            return false;
        }
        foreach ($data as $item) {
            if (!$this->denormalizer->supportsDenormalization($item, substr($type, 0, -2), $format)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!is_array($data)) {
            return null;
        }
        if ('[]' != substr($class, -2)) {
            return null;
        }

        $class = substr($class, 0, -2);
        $denormalized = [];
        foreach ($data as $key => $dataItem) {
            $denormalized[$key] = $this->denormalizer->denormalize($dataItem, $class, $format, $context);
        }

        return $denormalized;
    }
}