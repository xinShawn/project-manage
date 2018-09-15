<?php

namespace app\commands;


use app\models\cmd\CommandOption;
use yii\console\Controller;

/**
 * Class BaseController 所有命令行控制器的基类
 * @package app\commands
 */
abstract class BaseController extends Controller {

    public $defaultAction = "help";

    /**
     * 输出帮助信息
     * @return void
     * @throws BaseControllerException
     */
    public abstract function actionHelp();

    /**
     * 打印出好看的命令行提示
     * @param string $controllerName 控制器命令名称。如：NodeJsController 应输入：node-js
     * @param CommandOption[] $commandOptions 命令列表
     * @throws BaseControllerException
     */
    public function printPrettyActionArray($controllerName, array $commandOptions) {
        $actionMaxLen = $this->getActionMaxLen($commandOptions);
        $tabNum = ((int) ($actionMaxLen / 4)) + 1;

        echo "$controllerName 说明：" . PHP_EOL;
        foreach ($commandOptions as $commandOptionModel) {
            $this->echoActionCommon($controllerName, $commandOptionModel->action, $commandOptionModel->common, $tabNum);
        }
    }

    /**
     * @param array $commandOptions
     * @return int
     * @throws BaseControllerException
     */
    private function getActionMaxLen(array & $commandOptions) {
        $actionMaxLen = 0;

        foreach ($commandOptions as $commandOptionModel) {
            if (!$commandOptionModel->validate()) {
                throw new BaseControllerException("validate failed!");
            }

            $actionStrLen = strlen($commandOptionModel->action);
            if ($actionStrLen > $actionMaxLen) {
                $actionMaxLen = $actionStrLen;
            }
        }

        return $actionMaxLen;
    }

    /**
     * 输出动作的说明
     * @see BaseController::printPrettyActionArray 参数说明参考
     * @param string $controllerName
     * @param string $action
     * @param string $common
     * @param int $tabNum
     */
    private function echoActionCommon($controllerName, $action, $common, $tabNum) {
        $needTabNum = $tabNum - ((int) (strlen($action) / 4));
        $tabStr = $this->getTabWithNum($needTabNum);
        echo "\t[" . $controllerName . "/" . $action . "]" . $tabStr . $common . PHP_EOL;
    }

    /**
     * @param int $tabNum 所需的 tab 数量
     * @return string
     */
    private function getTabWithNum($tabNum) {
        $tabStr = "";

        for ($i = 0; $i < $tabNum; ++$i) {
            $tabStr .= "\t";
        }
        return $tabStr;
    }
}