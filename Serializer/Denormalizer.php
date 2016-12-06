<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/7:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class Denormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{

    use DenormalizerAwareTrait;

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if (is_array($data)) {
            $result = $this->checkArray($data, $type, $format);
        } else {
            $result = $this->checkObject($data, $type, $format);
        }

        return $result;
    }

    private function checkArray(array $data, $type, $format = null)
    {
        $result = false;
        foreach ($data as $item) {
            if ($this->supportsDenormalization($item, $type, $format)) {
                $result = true;
                break;
            }
        }

        return $result;
    }

    /**
     * @param $object
     * @param $type
     * @param null $format
     * @return bool
     */
    abstract protected function checkObject($object, $type, $format = null);

    /**
     * @inheritdoc
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (is_array($data)) {
            $result = $this->processArray($data, $class, $format);
        } else {
            $result = $this->processObject($data, $class, $format, $context);
        }

        return $result;
    }

    /**
     * @param $data
     * @param $class
     * @param $format
     * @return array
     */
    private function processArray($data, $class, $format)
    {
        $result = [];
        foreach ($data as $key => $item) {
            if (!$this->checkObject($item, $class, $format)) {
                continue;
            }
            $result[$key] = $this->processObject($item, $class, $format);
        }

        return $result;
    }

    /**
     * @param $data
     * @param $class
     * @param $format
     * @param $context
     * @return mixed
     */
    abstract protected function processObject($data, $class, $format, array $context = array());
}
