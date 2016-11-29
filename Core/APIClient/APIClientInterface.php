<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:45 PM
 *
 */

namespace GoalAPI\SDKBundle\Core\APIClient;

interface APIClientInterface
{

    /**
     * @param $path
     * @param array $queryParameters
     * @param array $headers
     * @param string $method
     * @return Response\ResponseInterface
     */
    public function makeAPICall($path, array $queryParameters = [], array $headers = [], $method = 'GET');
}