<?php declare(strict_types=1);
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
     * @return string
     */
    public function getBody();

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
