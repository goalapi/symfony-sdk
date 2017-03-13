<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/25/16/11:29 AM
 *
 */

namespace GoalAPI\SDKBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class GoalAPISDKBundle extends Bundle
{
    const BUNDLE_ALIAS = 'goalapi';

    public function getContainerExtension()
    {
        if (!$this->extension) {
            $this->extension = $this->createContainerExtension();
        }

        return $this->extension;
    }
}