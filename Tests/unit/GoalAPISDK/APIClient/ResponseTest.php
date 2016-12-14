<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/1:06 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\GoalAPISDK\APIClient\APIResponse;
use GuzzleHttp\Psr7;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testGetData()
    {
        $guzzleResponse = $this->createPartialMock(
            Psr7\Response::class,
            [
                'getBody',
            ]
        );

        $body = [
            (object)[
                "id" => "1",
                "name" => "One",
            ],
            (object)[
                "id" => "2",
                "name" => "Two",
            ],
        ];
        $guzzleResponse->method('getBody')->willReturn(
            new BodyObject(
                $body
            )
        );
        /** @var Psr7\Response $guzzleResponse */
        $apiResponse = new APIResponse($guzzleResponse);
        $this->assertEquals($body, json_decode($apiResponse->getBody()));
    }


    public function testResponseStatus()
    {
        $guzzleResponse = $this->createPartialMock(
            Psr7\Response::class,
            [
                'getStatusCode',
                'getReasonPhrase',
            ]
        );
        $guzzleResponse->method('getStatusCode')->willReturn(
            200
        );
        $guzzleResponse->method('getReasonPhrase')->willReturn(
            'OK'
        );
        /** @var Psr7\Response $guzzleResponse */
        $apiResponse = new APIResponse($guzzleResponse);
        $this->assertEquals(200, $apiResponse->getStatusCode());
        $this->assertEquals('OK', $apiResponse->getStatusMessage());
    }
}

class BodyObject
{
    private $body;

    public function __construct($body)
    {
        $this->body = $body;
    }

    public function __toString()
    {
        return json_encode($this->body);
    }
}
