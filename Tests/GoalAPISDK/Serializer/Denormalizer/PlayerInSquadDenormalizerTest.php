<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/12/16/7:15 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use Symfony\Component\Serializer\Serializer;

class PlayerInSquadDenormalizerTest extends \PHPUnit_Framework_TestCase
{

    public function testDenormalizerOk()
    {
        $player = new Model\Player();
        $player->setId('batalla-augusto');
        $player->setName('Batalla Augusto');

        $playerInSquad = new Model\PlayerInSquad();
        $playerInSquad->setPlayer($player);

        $serializer = new Serializer(
            [
                new Normalizer\PlayerDenormalizer(),
                new Normalizer\PlayerInSquadDenormalizer(),
            ]
        );
        $this->assertEquals(
            $playerInSquad,
            $serializer->denormalize($this->getNormalized($playerInSquad), Model\PlayerInSquad::class)
        );
    }

    private function getNormalized(Model\PlayerInSquad $playerInSquad)
    {
        $json = '
            {
                "id": "'.$playerInSquad->getPlayer()->getId().'",
                "name": "'.$playerInSquad->getPlayer()->getName().'",
                "_links": {
                    "self": {
                        "href": "/players/'.$playerInSquad->getPlayer()->getId().'"
                    }
                },
                "number": "'.$playerInSquad->getNumber().'",
                "role": "'.$playerInSquad->getPosition().'"
            }        
        ';

        return json_decode($json);
    }
}
