<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 12/13/16/3:19 PM
 *
 */

namespace GoalAPI\SDKBundle\Model\MatchProperties\Status;

use GoalAPI\SDKBundle\Model\MatchProperties\MatchStatus;

class Scheduled extends MatchStatus
{

    public function __construct()
    {
        parent::__construct();
        $this->setStatus(self::STATUS_SCHEDULED);
    }
}
