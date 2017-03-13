<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/14/16/8:33 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\Serializer\Denormalizer;

use GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;
use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Tests\unit\includes;
use Symfony\Component\HttpFoundation\ParameterBag;

class MatchDenormalizerTest extends \PHPUnit_Framework_TestCase
{
    use includes\Serializer\GetSampleTrait;
    use includes\Serializer\CreateSerializerTrait;

    public function testDenormalizationOk()
    {
        $sampleMatchJson = $this->getSampleJson('match');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        $this->assertNotEmpty($denormalizedMatch->getId());
        $this->assertInstanceOf(\DateTime::class, $denormalizedMatch->getBeginTime());
        $this->assertInstanceOf(Model\Team::class, $denormalizedMatch->getHostsTeam());
        $this->assertInstanceOf(Model\Team::class, $denormalizedMatch->getVisitorsTeam());
        $this->assertInstanceOf(Model\MatchProperties\MatchStatus::class, $denormalizedMatch->getStatus());
        $this->assertInstanceOf(Model\Tournament::class, $denormalizedMatch->getTournament());
        $this->assertInstanceOf(Model\Season::class, $denormalizedMatch->getSeason());
        $this->assertInstanceOf(Model\Stage::class, $denormalizedMatch->getStage());
        $this->assertInstanceOf(ParameterBag::class, $denormalizedMatch->getContext());
    }

    public function testScheduled()
    {
        $sampleMatchJson = $this->getSampleJson('matches/scheduled');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        $this->assertInstanceOf(Model\MatchProperties\Status\Scheduled::class, $denormalizedMatch->getStatus());
        $this->assertEquals([0, 0], $denormalizedMatch->getStatus()->getScore());
    }

    public function testOnline1T()
    {
        $sampleMatchJson = $this->getSampleJson('matches/online/1t');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalizedMatch->getStatus();
        $this->assertInstanceOf(Model\MatchProperties\Status\Online::class, $matchStatus);
        $this->assertEquals(Model\MatchProperties\Status\Online::STATUS_ONLINE, $matchStatus->getStatus());
        $matchMoment = $matchStatus->getCurrentMoment();
        $this->assertEquals(Model\MatchProperties\MatchMoment::MATCH_PERIOD_FIRST_HALF, $matchMoment->getPeriod());
        $this->assertNotNull($matchMoment->getMinute());
    }

    public function testOnline2T()
    {
        $sampleMatchJson = $this->getSampleJson('matches/online/2t');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalizedMatch->getStatus();
        $matchMoment = $matchStatus->getCurrentMoment();
        $this->assertEquals(Model\MatchProperties\MatchMoment::MATCH_PERIOD_SECOND_HALF, $matchMoment->getPeriod());
        $this->assertNotNull($matchMoment->getMinute());
    }

    public function testOnlineHT()
    {
        $sampleMatchJson = $this->getSampleJson('matches/online/ht');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalizedMatch->getStatus();
        $matchMoment = $matchStatus->getCurrentMoment();
        $this->assertEquals(Model\MatchProperties\MatchMoment::MATCH_PERIOD_HALF_TIME_BREAK, $matchMoment->getPeriod());
        $this->assertNull($matchMoment->getMinute());
    }

    public function testOnlineEHT()
    {
        $sampleMatchJson = $this->getSampleJson('matches/online/eht');
        $sampleMatchObject = json_decode($sampleMatchJson);

        /** @var Model\Match $denormalizedMatch */
        $denormalizedMatch = $this->createSerializer()->denormalize(
            $sampleMatchObject,
            Model\Match::class
        );

        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalizedMatch->getStatus();
        $matchMoment = $matchStatus->getCurrentMoment();
        $this->assertEquals(
            Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME_BREAK,
            $matchMoment->getPeriod()
        );
        $this->assertNull($matchMoment->getMinute());
    }

    public function testExtraTime()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/online/et')),
            Model\Match::class
        );
        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalized->getStatus();
        $this->assertEquals(
            Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME,
            $matchStatus->getCurrentMoment()->getPeriod()
        );
    }

    public function testE1T()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/online/e1t')),
            Model\Match::class
        );
        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalized->getStatus();
        $this->assertEquals(
            Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME_FIRST_HALF,
            $matchStatus->getCurrentMoment()->getPeriod()
        );
    }

    public function testE2T()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/online/e2t')),
            Model\Match::class
        );
        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalized->getStatus();
        $this->assertEquals(
            Model\MatchProperties\MatchMoment::MATCH_PERIOD_EXTRA_TIME_SECOND_HALF,
            $matchStatus->getCurrentMoment()->getPeriod()
        );
    }


    public function testSquads()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/with_squads')),
            Model\Match::class
        );

        $squads = [
            'hosts_players' => $denormalized->getHostsPlayers(),
            'visitors_players' => $denormalized->getVisitorsPlayers(),
            'hosts_substitutions' => $denormalized->getHostsSubstitutions(),
            'visitors_substitutions' => $denormalized->getVisitorsSubstitutions(),
        ];


        foreach ($squads as $squad) {
            $this->assertNotEmpty($squad);
            /** @var Model\PlayerInSquad $playerInSquad */
            foreach ($squad as $playerInSquad) {
                $this->assertInstanceOf(Model\PlayerInSquad::class, $playerInSquad);
                $this->assertInstanceOf(Model\Player::class, $playerInSquad->getPlayer());
                $playerInSquad->getPosition();
                $this->assertGreaterThan(0, $playerInSquad->getNumber());
            }
        }
    }


    public function testEvents()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/with_events')),
            Model\Match::class
        );

        $matchEvents = $denormalized->getEvents();
        $this->assertArrayHasKey(0, $matchEvents);

        /** @var Model\MatchProperties\MatchEvent[] $matchEvents */
        foreach ($matchEvents as $matchEvent) {
            $this->assertInstanceOf(Model\MatchProperties\MatchEvent::class, $matchEvent);
            $this->assertInstanceOf(Model\Team::class, $matchEvent->getTeam());
            $this->assertNotEmpty($matchEvent->getType());
            $eventMoment = $matchEvent->getMoment();
            $this->assertInstanceOf(Model\MatchProperties\MatchMoment::class, $eventMoment);
            $this->assertNotEmpty($eventMoment->getMinute());
            switch (get_class($matchEvent)) {
                case Model\MatchProperties\Event\Goal::class:
                    /** @var Model\MatchProperties\Event\Goal $matchEvent */
                    $this->assertInstanceOf(Model\Player::class, $matchEvent->getPlayer());
                    break;

                case Model\MatchProperties\Event\Card::class:
                    /** @var Model\MatchProperties\Event\Card $matchEvent */
                    $this->assertInstanceOf(Model\Player::class, $matchEvent->getPlayer());
                    $this->assertNotEmpty($matchEvent->getColor());
                    break;

                case Model\MatchProperties\Event\PenaltyMissed::class:
                    /** @var Model\MatchProperties\Event\PenaltyMissed $matchEvent */
                    $this->assertInstanceOf(Model\Player::class, $matchEvent->getPlayer());
                    break;

                case Model\MatchProperties\Event\Substitution::class:
                    /** @var Model\MatchProperties\Event\Substitution $matchEvent */
                    $this->assertInstanceOf(Model\Player::class, $matchEvent->getPlayerIn());
                    $this->assertInstanceOf(Model\Player::class, $matchEvent->getPlayerOut());
                    $this->assertNotEquals($matchEvent->getPlayerIn(), $matchEvent->getPlayerOut());
                    break;
            }
        }

    }

    public function testPostponed()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/abnormal/postponed')),
            Model\Match::class
        );
        $matchStatus = $denormalized->getStatus();
        $this->assertInstanceOf(
            Model\MatchProperties\Status\Abnormal::class,
            $matchStatus
        );
        $this->assertEquals(Model\MatchProperties\MatchStatus::STATUS_POSTPONED, $matchStatus->getStatus());
    }

    public function testCanceled()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/abnormal/canceled')),
            Model\Match::class
        );
        $matchStatus = $denormalized->getStatus();
        $this->assertInstanceOf(
            Model\MatchProperties\Status\Abnormal::class,
            $matchStatus
        );
        $this->assertEquals(Model\MatchProperties\MatchStatus::STATUS_CANCELED, $matchStatus->getStatus());
    }

    public function testInterrupted()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/abnormal/interrupted')),
            Model\Match::class
        );
        $matchStatus = $denormalized->getStatus();
        $this->assertInstanceOf(
            Model\MatchProperties\Status\Abnormal::class,
            $matchStatus
        );
        $this->assertEquals(Model\MatchProperties\MatchStatus::STATUS_INTERRUPTED, $matchStatus->getStatus());
    }

    public function testWrongStatus()
    {
        $this->expectException(\InvalidArgumentException::class);

        $matchObject = json_decode($this->getSampleJson('matches/abnormal/interrupted'));
        $matchObject->status->status = 'wrong_status';

        $this->createSerializer()->denormalize(
            $matchObject,
            Model\Match::class
        );
    }

    public function testPS()
    {
        /** @var Model\Match $denormalized */
        $denormalized = $this->createSerializer()->denormalize(
            json_decode($this->getSampleJson('matches/online/ps')),
            Model\Match::class
        );
        /** @var Model\MatchProperties\Status\Online $matchStatus */
        $matchStatus = $denormalized->getStatus();
        $this->assertEquals(
            Model\MatchProperties\MatchMoment::MATCH_PERIOD_PENALTY_SHOOTOUT,
            $matchStatus->getCurrentMoment()->getPeriod()
        );

        $penaltyShootoutKicks = $denormalized->getPenaltyShootoutKicks();
        $this->assertNotNull($penaltyShootoutKicks);
        $this->assertNotEmpty($penaltyShootoutKicks);

        foreach ($penaltyShootoutKicks as $penaltyShootoutKick) {
            $this->assertInstanceOf(Model\MatchProperties\Event\PenaltyShootoutKick::class, $penaltyShootoutKick);
            if (!$penaltyShootoutKick->isMissed()) {
                $score = $penaltyShootoutKick->getScore();
                $this->assertArrayHasKey(0, $score);
                $this->assertArrayHasKey(1, $score);
            }
            $this->assertInstanceOf(Model\Team::class, $penaltyShootoutKick->getTeam());
            $this->assertInstanceOf(Model\Player::class, $penaltyShootoutKick->getPlayer());
        }
    }

    public function testInvalidTypeDenormalization()
    {
        $obj = new \stdClass();
        $denormalizer = new Normalizer\MatchDenormalizer();
        $this->assertFalse($denormalizer->supportsDenormalization(\stdClass::class, $obj));

        try {
            $denormalizer->denormalize([], Model\Match::class);
            $this->fail('Exception should be thrown during denormalization of array by MatchDenormalizer');
        } catch (\Exception $x) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $x);
        }
        try {
            $denormalizer->denormalize($obj, Model\Match::class);
            $this->fail('Exception should be thrown during denormalization of array by MatchDenormalizer');
        } catch (\Exception $x) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $x);
        }
    }
}
