<?php
namespace GoalAPI\SDKBundle\GoalAPISDK;

use GoalAPI\SDKBundle\Core;

abstract class CallPerformer implements Core\CallPerformerInterface, Core\APIClient\APIClientAwareInterface
{

    use Core\APIClient\APIClientAwareTrait;

    /**
     * @inheritdoc
     */
    public function performCall(array $arguments)
    {
        if (call_user_func_array([$this, 'mustRefresh'], $arguments)) {
            $dataFromProvider = call_user_func_array([$this, 'loadDataFromProvider'], $arguments);
            $dataToSave = $arguments;
            $dataToSave[] = $dataFromProvider;
            call_user_func_array([$this, 'saveDataToLocalStorage'], $dataToSave);
            call_user_func_array([$this, 'updateNextRefreshTime'], $dataToSave);
            $dataToReturn = call_user_func_array([$this, 'deserializeData'], [$dataFromProvider]);
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
