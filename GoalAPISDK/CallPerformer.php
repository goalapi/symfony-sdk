<?php
namespace GoalAPI\SDKBundle\GoalAPISDK;

use GoalAPI\SDKBundle\APIClient;
use GoalAPI\SDKBundle\EventDispatcher;
use GoalAPI\SDKBundle\GoalAPISDK\EventDispatcher\Event\GoalAPISDKEvent;
use GoalAPI\SDKBundle\SDK;
use Symfony\Component\Serializer;

abstract class CallPerformer implements SDK\CallPerformerInterface, APIClient\APIClientAwareInterface, Serializer\SerializerAwareInterface, EventDispatcher\EventDispatcherAwareInterface
{

    use APIClient\APIClientAwareTrait;
    use Serializer\SerializerAwareTrait;
    use EventDispatcher\EventDispatcherAwareTrait;

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
            if ($i > 0) { // path should not start with slash
                $path .= '/';
            }
            $path .= $pathFragments[$i].'/'.urlencode($id);

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
            if ($this->eventDispatcher) {
                $this->eventDispatcher->dispatch(
                    GoalAPISDKEvent::LOAD,
                    new GoalAPISDKEvent($dataFromProvider, $arguments)
                );
            }
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
