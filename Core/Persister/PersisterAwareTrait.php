<?php
/**
 * Created by PhpStorm.
 * User: murat
 * Date: 11/25/16
 * Time: 4:48 PM
 */

namespace GoalAPI\SDKBundle\Core\Persister;

trait PersisterAwareTrait
{
    /**
     * @var PersisterInterface
     */
    private $persister;

    /**
     * @param PersisterInterface $persister
     */
    public function setPersister(PersisterInterface $persister)
    {
        $this->persister = $persister;
    }
}