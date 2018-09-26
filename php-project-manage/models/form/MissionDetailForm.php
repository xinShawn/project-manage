<?php
namespace app\models\form;

use app\models\db\Mission;
use app\utils\TimeUtil;

/**
 * Class MissionDetailForm 任务详情模型
 * @package app\models\form
 */
class MissionDetailForm extends BaseFormModel {
    /**
     * @var int 任务id
     */
    public $id;
    /**
     * @var string 任务标题
     */
    public $title;
    /**
     * @var string 任务内容
     */
    public $content;
    /**
     * @var int 优先级id
     */
    public $priority_id;
    /**
     * @var string 结束时间（非时间戳）
     */
    public $end_time;
    
    /**
     * @return array
     */
    public function rules() {
        return [
            [["id", "title", "content", "priority_id", "end_time"], "safe"]
        ];
    }
    
    /**
     * @param array $values
     * @param bool $safeOnly
     */
    public function setAttributes($values, $safeOnly = true) {
        if (is_numeric($values["end_time"])) {
            $values["end_time"] = TimeUtil::timestampToTime($values["end_time"]);
        }
        parent::setAttributes($values, $safeOnly);
    }
    
    /**
     * 获取 Mission 对象
     * @return Mission
     */
    public function toMission() {
        $mission = new Mission();
        $mission->setAttributes($this->toArray());
        return $mission;
    }
}