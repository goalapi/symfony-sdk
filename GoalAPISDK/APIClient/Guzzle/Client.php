<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:56 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\APIClient\Guzzle;

use GoalAPI\SDKBundle\Core\APIClient\APIClientInterface;
use GuzzleHttp;

class Client implements APIClientInterface
{

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $apikey;

    /**
     * APIClient constructor.
     * @param string $baseUri
     * @param string $apikey
     */
    function __construct($baseUri, $apikey)
    {
        $this->setBaseUri($baseUri);
        $this->setApikey($apikey);
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @param string $apikey
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * @inheritdoc
     */
    public function makeAPICall($path, array $queryParameters = [], array $headers = [], $method = 'GET')
    {
        $client = $this->createClient();
        $requestOptions = [];
        if (sizeof($headers)) {
            $requestOptions['headers'] = $headers;
        }
        $path .= '?'.GuzzleHttp\Psr7\build_query($queryParameters);
        $guzzleResponse = $client->request($method, $path, $requestOptions);
        $response = new Response($guzzleResponse);

        return $response;
    }

    /**
     * @return GuzzleHttp\Client
     */
    public function createClient()
    {
        $client = new GuzzleHttp\Client(
            [
                'base_uri' => $this->baseUri,
                'allow_redirects' => true,
                'headers' => [
                    'X-AUTH-APIKEY' => $this->apikey,
                ],
            ]
        );

        return $client;
    }
}