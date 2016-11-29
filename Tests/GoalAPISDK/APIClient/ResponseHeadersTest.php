<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/12:30 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\GoalAPISDK\APIClient\Guzzle;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\ParameterBag;

class ResponseHeadersTest extends \PHPUnit_Framework_TestCase
{

    public function testGetHeaders()
    {
        $headers = $this->getHeaderFields();
        /** @var Response $guzzleResponse */
        $guzzleResponse = $this->createGuzzleResponseMock($headers);
        $apiResponse = new Guzzle\Response($guzzleResponse);
        $this->assertEquals(
            new ParameterBag($headers),
            $apiResponse->getHeaders()
        );
    }

    /**
     * @return array
     */
    private function getHeaderFields()
    {
        $headers = [
            'X-API-Version' => '1',
            'X-Total-Count' => '19',
            'Link' => '</v1/tournaments/eng_pl/seasons/20162017/matches/>; rel="prev", </v1/tournaments/eng_pl/seasons/20162017/matches/3/>; rel="next"',
        ];

        return $headers;
    }

    /**
     * @param array $headers
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createGuzzleResponseMock($headers)
    {
        $guzzleResponse = $this->createPartialMock(
            Response::class,
            [
                'getHeaders',
            ]
        );

        $guzzleResponse->method('getHeaders')->willReturnCallback(
            function () use ($headers) {
                foreach ($headers as &$header) {
                    $header = [$header];
                }

                return $headers;
            }
        );

        return $guzzleResponse;
    }

    public function testGetHeader()
    {
        $headers = $this->getHeaderFields();
        /** @var Response $guzzleResponse */
        $guzzleResponse = $this->createGuzzleResponseMock($headers);
        $apiResponse = new Guzzle\Response($guzzleResponse);
        $headerName = 'X-Total-Count';
        $this->assertEquals(
            $headers[$headerName],
            $apiResponse->getHeaders()->get($headerName)
        );
    }

    public function testGetLinks()
    {
        $headers = $this->getHeaderFields();
        /** @var Response $guzzleResponse */
        $guzzleResponse = $this->createGuzzleResponseMock($headers);
        $apiResponse = new Guzzle\Response($guzzleResponse);
        $links = $apiResponse->getLinks();
        $this->assertEquals(
            2,
            $links->count()
        );
        $this->assertTrue($links->has('prev'));
        $this->assertTrue($links->has('next'));

        $this->assertArrayHasKey('path', parse_url($links->get('prev')));
        $this->assertArrayHasKey('path', parse_url($links->get('next')));
    }

    public function testGetLink()
    {
        $headers = $this->getHeaderFields();
        /** @var Response $guzzleResponse */
        $guzzleResponse = $this->createGuzzleResponseMock($headers);
        $apiResponse = new Guzzle\Response($guzzleResponse);
        $this->assertArrayHasKey('path', parse_url($apiResponse->getLink('next')));
    }
}