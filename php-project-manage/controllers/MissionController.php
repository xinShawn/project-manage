<?php
namespace app\controllers;

use app\managers\MP;
use app\models\ApiReturn;
use app\models\db\CfgPriority;
use app\models\db\Mission;
use app\models\form\MissionDetailForm;

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
        $radio = $this->post("radio");
        $projectId = $this->post("projectId");
        $page = (int) $this->post("page");
        $rows = (int) $this->post("rows");
        
        $offset = ($page - 1) * $rows;
        $limit = $rows;
        
        $tableData = Mission::getTable($projectId, $radio, $offset, $limit);
        
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
    public function actionGetDetail() {
        $id = (int) $this->post("id");
        
        $missionDetailForm = Mission::getDetail($id);
        
        return ApiReturn::retSucc($missionDetailForm->toArray());
    }
    
    /**
     * 修改任务
     * @throws \Throwable
     * @throws \app\exceptions\ProcessException
     * @throws \yii\db\StaleObjectException
     */
    public function actionChange() {
        $missionDetailForm = MissionDetailForm::initByForm("form");
        
        MP::getMissionManager()->changeDetail($missionDetailForm);
        
        return ApiReturn::retSucc();
    }
}