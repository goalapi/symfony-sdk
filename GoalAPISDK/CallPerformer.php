<?php
namespace GoalAPI\SDKBundle\GoalAPISDK;

use GoalAPI\SDKBundle\APIClient;
use GoalAPI\SDKBundle\SDK;

abstract class CallPerformer implements SDK\CallPerformerInterface, APIClient\APIClientAwareInterface
{

    use APIClient\APIClientAwareTrait;

    /**
     * @inheritdoc
     */
    public function performCall(array $arguments)
    {
        if (call_user_func_array([$this, 'mustRefresh'], $arguments)) {
            $dataFromProvider = call_user_func_array([$this, 'loadDataFromProvider'], $arguments);
            $dataToReturn = call_user_func([$this, 'deserializeData'], $dataFromProvider);
            call_user_func_array([$this, 'saveDataToLocalStorage'], [$dataToReturn]);
            call_user_func_array([$this, 'updateNextRefreshTime'], [$arguments, $dataToReturn]);
        } else {
            $dataToReturn = call_user_func_array([$this, 'fetchDataFromLocalStorage'], $arguments);
        }
        return $dataToReturn;
    }

    public function mustRefresh()
    {
    }

    public function fetchDataFromLocalStorage()
    {
    }

    public function loadDataFromProvider()
    {
    }

    public function saveDataToLocalStorage()
    {
    }

    public function updateNextRefreshTime()
    {
    }

    public function deserializeData($data)
    {
    }
}
