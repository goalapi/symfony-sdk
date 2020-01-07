<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:52 PM
 *
 */

namespace GoalAPI\SDKBundle\APIClient;

use GoalAPI\SDKBundle\SDK\Exception\CallPerformerException;

trait APIClientAwareTrait
{

    /**
     * @var APIClientInterface
     */
    protected $apiClient;

    /**
     * @param APIClientInterface $client
     */
    public function setApiClient(APIClientInterface $client)
    {
        $this->apiClient = $client;
    }

    /**
     * @param String $url
     * @param array $queryParameters
     * @param array $headers
     * @param string $method
     * @return Response\ResponseInterface
     * @throws CallPerformerException
     */
    protected function makeAPICall($url, array $queryParameters = [], array $headers = [], $method = 'GET')
    {
        try {
            $response = $this->apiClient->makeAPICall($url, $queryParameters, $headers, $method);
        } catch (Exception\APIClientException $x) {
            throw new CallPerformerException(
                'Can not make API-call to data provider: '.$x->getMessage(),
                $x->getCode(),
                $x
            );
        }

        return $response;
    }

}

