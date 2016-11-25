<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 4:17 PM
 */

namespace GoalAPI\SDKBundle\Core\Persister;

interface PersisterAwareInterface
{
    /**
     * @param PersisterInterface $persister
     */
    function setPersister(PersisterInterface $persister);
}