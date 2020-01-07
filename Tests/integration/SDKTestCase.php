<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 3/13/17/10:11 PM
 *
 */

namespace GoalAPI\SDKBundle\Tests\integration;

use GoalAPI\SDKBundle\GoalAPISDK;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class SDKTestCase extends KernelTestCase
{
    /**
     * @var GoalAPISDK
     */
    private $sdk;

    protected function getSDKInstance()
    {
        if (!$this->sdk) {
            $_SERVER['KERNEL_DIR'] = __DIR__.'/app';
            self::bootKernel();
            $this->sdk = self::$kernel->getContainer()->get('goalapi.sdk');
        }

        return $this->sdk;
    }
}
