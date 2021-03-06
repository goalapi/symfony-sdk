<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:56 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\APIClient\Guzzle;

use GoalAPI\SDKBundle\APIClient\Exception\APIClientException;
use GoalAPI\SDKBundle\GoalAPISDK\APIClient;
use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;

class Client extends APIClient\APIClient
{
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

        try {
            $guzzleResponse = $client->request($method, $path, $requestOptions);
        } catch (GuzzleException $x) {
            throw new APIClientException($x->getMessage(), $x->getCode(), $x);
        }

        $response = new APIClient\APIResponse($guzzleResponse);

        return $response;
    }

    /**
     * @return GuzzleHttp\Client
     */
    public function createClient()
    {
        $client = new GuzzleHttp\Client(
            [
                'base_uri' => $this->getBaseUri(),
                'allow_redirects' => true,
                'headers' => [
                    'X-AUTH-APIKEY' => $this->getApikey(),
                    "Content-Type" => "application/json"
                ],
            ]
        );

        return $client;
    }
}