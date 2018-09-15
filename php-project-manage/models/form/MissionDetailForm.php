<?php
namespace app\models\form;

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
     * @return array
     */
    public function rules() {
        return [
            [["id", "title", "content"], "safe"]
        ];
    }
}