<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/26/16/8:31 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\CallPerformers;

use GoalAPI\SDKBundle\GoalAPISDK\CallPerformer;
use GoalAPI\SDKBundle\Model;
use GuzzleHttp\Client;

class GetSubscription extends CallPerformer
{
    /**
     * @var string
     */
    private $apikey;

    /**
     * GetSubscription constructor.
     * @param $apikey
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }

    public function loadDataFromProvider()
    {
        $guzzleClient = new Client(
            [
                'base_uri' => 'http://api.goalapi.com/v1/',
                'headers' => [
                    'X-AUTH-APIKEY' => $this->apikey,
                ],
            ]
        );
        $response = $guzzleClient->get('');
        $body = json_decode($response->getBody(), true);

        return $body;
    }


    public function deserializeData($data)
    {
        $subscription = new Model\Subscription();
        $subscription->setStatus($data['status']);
        $subscription->setExpirationTime(new \DateTime($data['expirationTime']['date_time']));

        if (isset($data['allowedTournaments'])) {
            $tournamentObjects = [];
            foreach ($data['allowedTournaments'] as $tournamentItem) {
                $tournamentObject = new Model\Tournament();
                $tournamentObject->setId($tournamentItem['id']);
                $tournamentObject->setName($tournamentItem['name']);
                $tournamentObjects[] = $tournamentObject;
            }
            $subscription->setTournaments($tournamentObjects);
        }

        return $subscription;
    }

    /**
     * @param string $apikey
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
    }

    public function mustRefresh()
    {
        return true;
    }
}
