<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 4:10 PM
 */

namespace GoalAPI\SDKBundle\Core\Persister;

interface PersisterInterface
{
    public function persist($obj);
}