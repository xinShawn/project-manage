<?php
namespace app\controllers;

use app\managers\MP;
use app\models\ApiReturn;
use app\models\db\CfgPriority;

/**
 * Class MissionController 任务控制器
 * @package app\controllers
 */
class MissionController extends BaseController {
    
    /**
     * 添加任务
     * @throws \Throwable
     */
    public function actionAdd() {
        $title = $this->param("title");
        $content = $this->param("content");
        $priorityId = $this->param("priorityId");
        $endTime = $this->param("endTime");
        
        if (empty($title) || empty($priorityId)) {
            return ApiReturn::retFailEmptyData();
        }
        if (!empty($endTime)) {
            $endTime = strtotime($endTime);
        }
        
        MP::getMissionManager()->add($title, $content, $priorityId, $endTime);
        
        return ApiReturn::retSucc();
    }
    
    /**
     * 获取优先级 详细信息 的数组（有排序）
     */
    public function actionGetPriorityRichOptions() {
        $richOptions = CfgPriority::getRichOptions();
        
        return ApiReturn::retSucc($richOptions);
    }
}