<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/11/16/9:30 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Serializer\Serializer;

class PlayerDenormalizerTest extends \PHPUnit_Framework_TestCase
{

    public function testDenormalizerOk()
    {
        $player = new Model\Player();
        $player->setId('bellerin-hector');
        $player->setName('Bellerin Hector');
        $player->setPosition('forward');
        $player->setNames(
            new ParameterBag(
                [
                    "first" => "Hector",
                    "last" => "Bellerin",
                ]
            )
        );
        $player->setBio(
            new ParameterBag(
                [
                    "height" => "189cm",
                    "weight" => "80kg",
                ]
            )
        );

        $country = new Model\Territory();
        $country->setId('esp');
        $country->setName('Spain');
        $player->setCountry($country);

        $normalized = $this->getNormalized($player);

        $serializer = new Serializer(
            [
                new Normalizer\PlayerDenormalizer(),
                new Normalizer\TerritoryDenormalizer(),
            ]
        );
        $this->assertEquals(
            $player,
            $serializer->denormalize($normalized, Model\Player::class)
        );

    }

    private function getNormalized(Model\Player $player)
    {
        $json = '
{
    "id": "'.$player->getId().'",
    "name": "'.$player->getName().'",
    "_links": {
        "self": {
            "href": "/players/'.$player->getId().'"
        }
    },
    "names": {
        "first": "'.$player->getNames()->get('first').'",
        "last": "'.$player->getNames()->get('last').'"
    },
    "bio": {
        "height": "'.$player->getBio()->get('height').'",
         "weight": "'.$player->getBio()->get('weight').'"
    },
    "position": "'.$player->getPosition().'",
    "country": {
        "id": "'.$player->getCountry()->getId().'",
        "name": "'.$player->getCountry()->getName().'",
        "_links": {
            "self": {
                "href": "/territories/'.$player->getCountry()->getId().'"
            }
        }
    }
}        
        ';

        return json_decode($json);
    }
}
