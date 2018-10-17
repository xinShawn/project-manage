<?php
namespace app\controllers;

use app\managers\MP;
use app\models\ApiReturn;
use app\models\db\Project;
use app\utils\SessionUtil;

/**
 * Class ProjectController 项目控制器
 * @package app\controllers
 */
class ProjectController extends BaseController {
 
    /**
     * 添加项目
     * @return string
     * @throws \Throwable
     * @throws \app\exceptions\ProcessException
     */
    public function actionAdd() {
        $name = $this->post("name");
        $remark = $this->post("remark");
        
        MP::getProjectManager()->add($name, $remark);
        
        return ApiReturn::retSucc();
    }
    
    /**
     * 获取表格数据
     */
    public function actionGetTable() {
        $tableData = Project::getTable();
        
        return ApiReturn::retSucc($tableData);
    }
    
    /**
     * 获取选项数据
     * @return string
     */
    public function actionGetOptions() {
        $options = Project::getOptions();
        
        return ApiReturn::retSucc($options);
    }
    
    /**
     * 设置 session 当前选中项目的项目id
     */
    public function actionSetProjectId() {
        $projectId = $this->post("projectId");
        SessionUtil::set(SessionUtil::KEY_PROJECT_ID, $projectId);
        
        return ApiReturn::retSucc();
    }
    
    /**
     * 获取项目id
     */
    public function actionGetProjectId() {
        $projectId = SessionUtil::get(SessionUtil::KEY_PROJECT_ID, null);
        
        return ApiReturn::retSucc($projectId);
    }
}