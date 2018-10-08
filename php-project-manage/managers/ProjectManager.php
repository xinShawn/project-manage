<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/9/29
 * Time: 9:50
 */

namespace app\managers;

use app\exceptions\ProcessException;
use app\models\db\Project;

/**
 * Class ProjectManager 项目 manager
 * @package app\managers
 */
class ProjectManager {
    private static $shareInstance = null;
    private function __construct() {
    }
    
    /**
     * @return ProjectManager
     */
    public static function getInstance() {
        if (self::$shareInstance === null) {
            self::$shareInstance = new static();
        }
        return self::$shareInstance;
    }
    
    /**
     * @param $name
     * @param $remark
     * @throws ProcessException
     * @throws \Throwable
     */
    public function add($name, $remark) {
        if (Project::find()->where(["name" => $name])->count() != 0) {
            throw new ProcessException("已有相同的项目存在");
        }
        
        $time = time();
        
        $project = new Project();
        
        $project->name = $name;
        $project->remark = $remark;
        $project->status = Project::STATUS_NOT_START;
        $project->last_user_id = MP::getUserManager()->getCurrentUserId();
        $project->update_time = $time;
        $project->create_time = $time;
        
        if ($project->insert() === false) {
            throw new ProcessException("数据写入失败");
        }
    }
}