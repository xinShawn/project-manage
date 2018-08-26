<?php

namespace app\models\cmd;


/**
 * Class CommandOptionModel 命令行参数模型。用于输出一个控制器可用的模型类型
 * @package app\models\cmd
 */
class CommandOptionModel extends BaseCmdModel {
    /**
     * @var string 动作
     */
    public $action;
    /**
     * @var string 说明
     */
    public $common;

    /**
     * @param string $action
     * @param string $common
     */
    public function __construct($action, $common) {
        parent::__construct();

        $this->action = $action;
        $this->common = $common;
    }

    /**
     * @return array 验证规则
     */
    public function rules() {
        return [
            [["action", "common"], "required"], // action 和 common 必须有
            [["action", "common"], "string"]    // action 和 common 类型是字符串
        ];
    }
}