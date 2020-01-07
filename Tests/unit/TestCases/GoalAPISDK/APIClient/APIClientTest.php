<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/5:23 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\unit\TestCases\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\GoalAPISDK\APIClient\Guzzle\Client;
use GuzzleHttp;
use PHPUnit\Framework\TestCase;

class APIClientTest extends TestCase
{

    public function testAPIClient()
    {
        $guzzleClient = $this->createPartialMock(
            GuzzleHttp\Client::class,
            [
                'request',
            ]
        );
        $guzzleClient->method('request')->willReturnCallback(
            function () {
                return new GuzzleHttp\Psr7\Response(
                    200,
                    [
                        'Link' => '</v1/tournaments/eng_pl/seasons/20162017/matches/>; rel="prev",  </v1/tournaments/eng_pl/seasons/20162017/matches/3/>; rel="next"',
                    ],
                    \GuzzleHttp\json_encode(func_get_args())
                );
            }
        );
        $apiClient = $this->createPartialMock(
            Client::class,
            [
                'createClient',
            ]
        );
        $apiClient->method('createClient')->willReturn($guzzleClient);

        /** @var Client $apiClient */
        $response = $apiClient->makeAPICall('example/call', ['param' => 'one']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(null != $response->getBody()->__toString());
        $this->assertArrayHasKey('path', parse_url($response->getLink('prev')));
    }
}
