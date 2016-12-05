<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/10:51 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\APIClient\Guzzle;

use GoalAPI\SDKBundle\APIClient\Response\ResponseInterface;
use GuzzleHttp;
use Psr\Http\Message;
use Symfony\Component\HttpFoundation;

class Response implements ResponseInterface
{

    /**
     * @var Message\ResponseInterface
     */
    private $guzzleResponse;

    /**
     * @var HttpFoundation\ParameterBag
     */
    private $headers;

    /**
     * @var HttpFoundation\ParameterBag
     */
    private $links;

    /**
     * Response constructor.
     * @param Message\ResponseInterface $response
     */
    function __construct(Message\ResponseInterface $response)
    {
        $this->guzzleResponse = $response;
    }

    /**
     * @param bool $rawFormat
     * @return array|object|string
     */
    public function getData($rawFormat = false)
    {
        $data = $this->guzzleResponse->getBody()->__toString();
        if (!$rawFormat) {
            $data = json_decode($data);
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->guzzleResponse->getStatusCode();
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->guzzleResponse->getReasonPhrase();
    }

    /**
     * @param string $linkName
     * @return string
     */
    public function getLink($linkName)
    {
        return $this->getLinks()->get($linkName);
    }

    /**
     * @return HttpFoundation\ParameterBag
     */
    public function getLinks()
    {
        if (!$this->links) {
            $this->links = new HttpFoundation\ParameterBag();
            if ($this->hasLinks()) {
                $linkHeaderString = $this->getHeader('Link');
                foreach ($this->parseLinkHeader($linkHeaderString) as $linkName => $linkHref) {
                    $this->links->set($linkName, $linkHref);
                }
            }
        }

        return $this->links;
    }

    /**
     * @return bool
     */
    public function hasLinks()
    {
        return $this->getHeaders()->has('Link');
    }

    /**
     * @return HttpFoundation\ParameterBag
     */
    public function getHeaders()
    {
        if (!$this->headers) {
            $this->headers = new HttpFoundation\ParameterBag();
            foreach ($this->guzzleResponse->getHeaders() as $headerName => $header) {
                $this->headers->set($headerName, implode(', ', $header));
            }
        }

        return $this->headers;
    }

    /**
     * @param $headerName
     * @return string
     */
    public function getHeader($headerName)
    {
        $headers = $this->getHeaders();
        return $headers->get($headerName);
    }

    /**
     * @param $linkString
     * @return string[] Key-Value array of strings; keys are "rel" attribute of link, values is "href"
     */
    private function parseLinkHeader($linkString)
    {
        $parsedLinks = [];
        $parsedHeader = GuzzleHttp\Psr7\parse_header($linkString);
        foreach ($parsedHeader as $parsedLink) {
            $href = $parsedLink[0];
            $href = trim($href, '<>');
            $parsedLinks[$parsedLink['rel']] = $href;
        }

        return $parsedLinks;
    }
}
