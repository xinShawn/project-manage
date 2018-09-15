<?php
namespace app\controllers;

use app\managers\MP;
use app\models\ApiReturn;
use app\models\db\CfgPriority;
use app\models\db\Mission;

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
        $title = $this->post("title");
        $content = $this->post("content");
        $priorityId = $this->post("priorityId");
        $endTime = $this->post("endTime");
        
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
    
    /**
     * 获取任务表格的数据
     */
    public function actionGetMissionTable() {
        $tableData = Mission::getTable(0, 50);
        
        return ApiReturn::retSucc($tableData);
    }
    
    /**
     * 修改任务状态
     * @return string
     * @throws \Throwable
     * @throws \app\exceptions\ProcessException
     * @throws \yii\db\StaleObjectException
     */
    public function actionChangeMissionStatus() {
        $id = $this->post("id");
        $toStatus = $this->post("toStatus");
        
        MP::getMissionManager()->changeStatus($id, $toStatus);
        
        return ApiReturn::retSucc();
    }
    
    /**
     * 获取任务详情的数据
     */
    public function actionGetMission() {
        $id = (int) $this->post("id");
        
        $missionDetailForm = MP::getMissionManager()->getDetail($id);
        
        return ApiReturn::retSucc($missionDetailForm->toArray());
    }
}