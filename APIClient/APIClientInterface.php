<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:45 PM
 *
 */

namespace GoalAPI\SDKBundle\APIClient;

interface APIClientInterface
{

    /**
     * @param $path
     * @param array $queryParameters
     * @param array $headers
     * @param string $method
     * @return Response\ResponseInterface
     * @throws Exception\APIClientException
     */
    public function makeAPICall($path, array $queryParameters = [], array $headers = [], $method = 'GET');
}