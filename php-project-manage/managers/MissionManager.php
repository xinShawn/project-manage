<?php
namespace app\managers;


use app\exceptions\ProcessException;
use app\models\db\Mission;
use Yii;

/**
 * Class MissionManager 任务 manager
 * @package app\managers
 */
class MissionManager {
    private static $shareInstance = null;
    private function __construct() {
    }
    
    /**
     * @return MissionManager
     */
    public static function getInstance() {
        if (self::$shareInstance === null) {
            self::$shareInstance = new static();
        }
        return self::$shareInstance;
    }
    
    
    /**
     * 添加一条任务
     * @param string $title 标题id
     * @param string $content 内容
     * @param int $priorityId 优先级id
     * @param int $endTime 截止时间
     * @throws \Throwable
     */
    public function add($title, $content, $priorityId, $endTime = 0) {
        $currentTime = time();
        $currentUserId = MP::getUserManager()->getCurrentUserId();
        
        $mission = new Mission();
        
        $mission->priority_id = $priorityId;
        $mission->title = $title;
        $mission->content = $content;
        $mission->status = Mission::STATUS_NOT_START;
        $mission->end_time = $endTime;
        $mission->finish_user_id = 0;
        $mission->create_user_id = $currentUserId;
        $mission->last_user_id = $currentUserId;
        $mission->update_time = $currentTime;
        $mission->create_time = $currentTime;
        
        if ($mission->insert() === false) {
            throw new ProcessException(Yii::t("app", "Data write failed"));
        }
    }
    
    /**
     * 修改任务状态
     * @param int $id 任务id
     * @param int $status 需要转换到的任务状态
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function changeStatus($id, $status) {
        // 检验状态值是否合法
        $statusOptions = Mission::getStatusOptions();
        if (!isset($statusOptions[$status])) {
            throw new ProcessException(Yii::t("app", "illegal status value") . ". [status: " . $status . "]");
        }
        
        $mission = Mission::findOne(["id" => $id]);
        
        $mission->status = $status;
        $mission->update_time = time();
        $mission->last_user_id = MP::getUserManager()->getCurrentUserId();
        
        if ($mission->update() === false) {
            throw new ProcessException(Yii::t("app", "Data update failed"));
        }
    }
}