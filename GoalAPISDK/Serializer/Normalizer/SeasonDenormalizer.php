<?php declare(strict_types=1);
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
    public function supportsDenormalization($object,string $type, string $format = null)
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
    public function denormalize($object,string $class, string $format = null, array $context = array())
    {
        $season = new Model\Season();
        if (isset($object->_links->self)) {
            $link = $object->_links->self->href;
            $link = trim($link, '/');
            $link = explode('/', $link);
            $season->setId($link[1].'.'.$link[3]);
        }
        $season->setName($object->name);

        if (isset($object->tournament)) {
            /** @var Model\Tournament $tournament */
            $tournament = $this->denormalizer->denormalize(
                $object->tournament,
                Model\Tournament::class,
                $format,
                $context
            );
            $season->setTournament(
                $tournament
            );
        }

        if (isset($object->stages) && is_array($object->stages)) {
            /** @var Model\Stage[] $stages */
            $stages = $this->denormalizer->denormalize(
                $object->stages,
                Model\Stage::class.'[]',
                $format,
                $context
            );
            $season->setStages($stages);
        }

        return $season;
    }
}
