<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 5/8/17/12:37 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\EventDispatcher;

use GoalAPI\SDKBundle\GoalAPISDK;
use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\GoalAPISDKTestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;

class GoalAPISDKEventTest extends GoalAPISDKTestCase
{

    public function testGoalAPISDKEvent()
    {
        $eventDispatcher = new EventDispatcher();

        /** @var EventListener $eventListener */
        $eventListener = new EventListener();

        $eventDispatcher->addListener(
            GoalAPISDK\EventDispatcher\Event\GoalAPISDKEvent::LOAD,
            [$eventListener, 'onDataLoad']
        );

        $responseBody = '[{"hi" => "there"}]';

        $sdk = new GoalAPISDK();
        $sdk->setApiClient($this->createAPIClient($responseBody));
        $sdk->setEventDispatcher($eventDispatcher);
        $sdk->addCallPerformer('someCall', new GoalAPICallPerformer());

        $sdk->someCall();

        $this->assertEquals($eventListener->event->getData(), $responseBody);
    }
}

class EventListener
{
    /**
     * @var GoalAPISDK\EventDispatcher\Event\GoalAPISDKEvent
     */
    public $event;

    public function onDataLoad(GoalAPISDK\EventDispatcher\Event\GoalAPISDKEvent $event)
    {
        $this->event = $event;
    }
}

class GoalAPICallPerformer extends CallPerformer
{
    public function loadDataFromProvider()
    {
        $response = $this->apiClient->makeAPICall('someurl');

        return $response->getBody();
    }

    public function mustRefresh()
    {
        return true;
    }
}