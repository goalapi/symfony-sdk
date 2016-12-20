<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/15/16/12:46 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\PHPUnit\includes\Serializer;

trait GetSampleTrait
{
    /**
     * @param String $typeOfSample
     * @return String
     * @throws \FileNotFoundException
     */
    protected function getSampleJson($typeOfSample)
    {
        $samplesPath = realpath(dirname(__FILE__).'/../../').'/Resources/samples';
        $sampleFilePath = $samplesPath.'/'.$typeOfSample.'.json';
        if (!is_readable($sampleFilePath)) {
            throw new \FileNotFoundException('Sample file for '.$typeOfSample.' not found in '.$samplesPath);
        }

        /** @var \stdClass $obj */
        $obj = file_get_contents($sampleFilePath);

        return $obj;
    }
}
