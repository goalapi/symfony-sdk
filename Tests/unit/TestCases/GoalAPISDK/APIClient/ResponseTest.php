<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/1:06 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\GoalAPISDK\APIClient\APIResponse;
use GuzzleHttp\Psr7;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
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
        $this->assertEquals($body, \GuzzleHttp\json_decode($apiResponse->getBody()));
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
        return \GuzzleHttp\json_encode($this->body);
    }
}
