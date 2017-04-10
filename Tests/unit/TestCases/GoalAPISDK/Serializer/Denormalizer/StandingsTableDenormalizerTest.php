<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/12:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer\ArrayDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Serializer\Serializer;

class StandingsTableDenormalizerTest extends TestCase
{

    public function testDenormalizerOk()
    {
        $standingsTable = new Model\StandingsTable();
        $standingsTable->setId('aaaaa');
        $standingsTable->setContext(
            new ParameterBag(
                [
                    'group' => 'A',
                ]
            )
        );

        $team = new Model\Team();
        $team->setId('spamos_rus');
        $team->setName('Spartak Moscow');

        $standingsTableRow = new Model\StandingsTableRow();
        $standingsTableRow->setTeam($team);
        $standingsTableRow->setPosition(1);
        $standingsTableRow->setPoints(23);
        $standingsTableRow->setMatches(
            [
                'played' => 11,
                'won' => 7,
                'draw' => 2,
                'lost' => 2,
            ]
        );
        $standingsTableRow->setGoals(
            [
                'scored' => 27,
                'conceded' => 8,
            ]
        );

        $standingsTable->setRows([$standingsTableRow]);

        $serializer = new Serializer(
            [
                new Normalizer\StandingsTableDenormalizer(),
                new Normalizer\TeamDenormalizer(),
                new ArrayDenormalizer(),
            ]
        );

        $this->assertEquals(
            $standingsTable,
            $serializer->denormalize($this->getNormalized($standingsTable), Model\StandingsTable::class)
        );
    }

    /**
     * @param Model\StandingsTable $standingsTable
     * @return object
     */
    private function getNormalized(Model\StandingsTable $standingsTable)
    {
        $obj = (object)[
            'id' => $standingsTable->getId(),
            'context' => (object)$standingsTable->getContext()->all(),
            'rows' => [],
        ];
        foreach ($standingsTable->getRows() as $standingsTableRow) {
            $obj->rows[] = (object)[
                'team' => (object)[
                    'id' => $standingsTableRow->getTeam()->getId(),
                    'name' => $standingsTableRow->getTeam()->getName(),
                ],
                'position' => $standingsTableRow->getPosition(),
                'points' => $standingsTableRow->getPoints(),
                'matches' => $standingsTableRow->getMatches(),
                'goals' => $standingsTableRow->getGoals(),
            ];
        }

        return $obj;
    }
}
