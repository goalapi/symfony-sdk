<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/10:49 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;

class SquadDenormalizerTest extends \PHPUnit_Framework_TestCase
{

    public function testDenormalizerOK()
    {
        $squad = new Model\Squad();

        $team = new Model\Team();
        $team->setId('fra_nat');
        $team->setName('France');
        $squad->setTeam($team);

        $player = new Model\Player();
        $player->setId('frank-ribery');
        $player->setName('Frank Ribery');
        $playerInSquad = new Model\PlayerInSquad();
        $playerInSquad->setPlayer($player);
        $playerInSquad->setPosition(Model\Player::PLAYER_POSITION_MIDFIELDER);
        $playerInSquad->setNumber(8);
        $squad->setPlayers(
            [
                $playerInSquad,
            ]
        );

        $serializer = new Serializer(
            [
                new Normalizer\PlayerInSquadDenormalizer(),
                new Normalizer\PlayerDenormalizer(),
                new Normalizer\SquadDenormalizer(),
                new Normalizer\TeamDenormalizer(),
                new ArrayDenormalizer(),

            ]
        );

        $this->assertEquals(
            $squad,
            $serializer->denormalize($this->getNormalized($squad), Model\Squad::class)
        );

    }

    /**
     * @param Model\Squad $squad
     * @return object
     */
    private function getNormalized(Model\Squad $squad)
    {
        $obj = (object)[
            'id' => $squad->getTeam()->getId(),
            'name' => $squad->getTeam()->getName(),
            'players' => [],
        ];
        foreach ($squad->getPlayers() as $playerInSquad) {
            $obj->players[] = (object)[
                'id' => $playerInSquad->getPlayer()->getId(),
                'name' => $playerInSquad->getPlayer()->getName(),
                'number' => $playerInSquad->getNumber(),
                'role' => $playerInSquad->getPosition(),
            ];
        }

        return $obj;
    }
}
