<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/11/16/9:30 AM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Serializer\Serializer;

class TeamDenormalizerTest extends TestCase
{

    public function testDenormalizerOk()
    {
        $serializer = new Serializer(
            [
                new Normalizer\TeamDenormalizer(),
                new Normalizer\TerritoryDenormalizer(),
            ]
        );

        $team = new Model\Team();
        $team->setId('spamos_rus');
        $team->setName('Spartak Moscow');
        $team->setType(Model\Team::TYPE_CLUB);
        $team->setNames(
            new ParameterBag(
                [
                    'short' => 'SPM',
                ]
            )
        );

        $country = new Model\Territory();
        $country->setId('rus');
        $country->setName('Russia');
        $team->setCountry($country);

        $this->assertEquals(
            $team,
            $serializer->denormalize($this->getNormalized($team), Model\Team::class)
        );
    }

    private function getNormalized(Model\Team $team)
    {
        $json = '
{
    "id": "'.$team->getId().'",
    "name": "'.$team->getName().'",
    "_links": {
        "self": {
            "href": "/teams/'.$team->getId().'"
        }
    },
    "names": {
        "short": "'.$team->getNames()->get('short').'"
    },
    "type": "'.$team->getType().'",
    "country": {
        "id": "'.$team->getCountry()->getId().'",
        "name": "'.$team->getCountry()->getName().'",
        "_links": {
            "self": {
                "href": "/territories/'.$team->getCountry()->getId().'"
            }
        }
    }
}        ';

        return \GuzzleHttp\json_decode($json);
    }
}
