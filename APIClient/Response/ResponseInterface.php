<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/10:26 AM
 *
 */

namespace GoalAPI\SDKBundle\APIClient\Response;

use Symfony\Component\HttpFoundation;

interface ResponseInterface
{
    /**
     * @param bool $rawFormat
     * @return array|object|string
     */
    public function getData($rawFormat = false);

    /**
     * @return HttpFoundation\ParameterBag
     */
    public function getHeaders();

    /**
     * @param $headerName
     * @return string
     */
    public function getHeader($headerName);

    /**
     * @return int
     */
    public function getStatusCode();

    /**
     * @return string
     */
    public function getStatusMessage();

    /**
     * @return bool
     */
    public function hasLinks();

    /**
     * @return HttpFoundation\ParameterBag
     */
    public function getLinks();

    /**
     * @param string $linkName
     * @return string
     */
    public function getLink($linkName);
}
