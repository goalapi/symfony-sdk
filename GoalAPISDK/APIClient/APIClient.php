<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/28/16/4:56 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\APIClient\APIClientInterface;

abstract class APIClient implements APIClientInterface
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
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return string
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * @param string $apikey
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
    }
}