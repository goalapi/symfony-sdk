<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/10:51 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\APIClient;

use GoalAPI\SDKBundle\APIClient\Response\ResponseInterface;
use GuzzleHttp;
use Psr\Http\Message;
use Symfony\Component\HttpFoundation;

class APIResponse implements ResponseInterface
{

    /**
     * @var HttpFoundation\ParameterBag
     */
    private $headers;

    /**
     * @var HttpFoundation\ParameterBag
     */
    private $links;
    /**
     * @var Message\ResponseInterface
     */
    private $response;

    /**
     * Response constructor.
     * @param Message\ResponseInterface $response
     */
    function __construct(Message\ResponseInterface $response)
    {
        $this->setResponse($response);
    }

    /**
     * @inheritdoc
     */
    public function getBody()
    {
        return $this->response->getBody();
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->response->getReasonPhrase();
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
            foreach ($this->response->getHeaders() as $headerName => $header) {
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

    /**
     * @return Message\ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Message\ResponseInterface $response
     */
    public function setResponse(Message\ResponseInterface $response)
    {
        $this->response = $response;
    }
}
