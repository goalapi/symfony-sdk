<?php
namespace GoalAPI\SDKBundle\GoalAPISDK;

use GoalAPI\SDKBundle\APIClient;
use GoalAPI\SDKBundle\SDK;
use Symfony\Component\Serializer;

abstract class CallPerformer implements SDK\CallPerformerInterface, APIClient\APIClientAwareInterface, Serializer\SerializerAwareInterface
{

    use APIClient\APIClientAwareTrait;
    use Serializer\SerializerAwareTrait;

    /**
     * @param array $ids
     * @return string
     */
    public static function pathFromIds(array $ids)
    {
        $pathFragments = [
            'tournaments',
            'seasons',
            'stages',
        ];
        $path = '';
        $idsCount = sizeof($ids);
        for ($i = 0; $i < $idsCount; $i++) {
            $id = $ids[$i];
            if ($i > 0 && 0 === strpos($id, $ids[$i - 1])) {
                $id = substr($id, strlen($ids[$i - 1]) + 1);
            }
            $path .= '/'.$pathFragments[$i].'/'.urlencode($id);
        }

        return $path;
    }

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
