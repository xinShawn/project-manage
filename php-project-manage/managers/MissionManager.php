<?php
namespace app\managers;


use app\exceptions\ProcessException;
use app\models\db\Mission;
use app\models\form\MissionDetailForm;
use Yii;
use yii\db\ActiveQuery;

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
        $currentUserId = MP::getUserManager()->helper->getSessionUserId();
        
        if (empty($content)) {
            $content = "[无]";
        }
        
        $mission = new Mission();
        $projectId = MP::getProjectManager()->getSessionProjectId();
        if ($projectId === 0) {
            throw new ProcessException(Yii::t("app", "No project is currently selected"));
        }
        
        $mission->project_id = $projectId;
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
        $mission->last_user_id = MP::getUserManager()->helper->getSessionUserId();
        
        if ($mission->update() === false) {
            throw new ProcessException(Yii::t("app", "Data update failed"));
        }
    }
    
    /**
     * 修改任务
     * @param MissionDetailForm $missionDetailForm
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function changeDetail(MissionDetailForm $missionDetailForm) {
        $oldMission = Mission::findOne(["id" => $missionDetailForm->id]);
        $newMissionData = $missionDetailForm->toMission()->toArray();
        
        foreach ($newMissionData as $prop => $value) {
            $oldMission->$prop = $value;
        }
        
        if ($oldMission->update() === false) {
            throw new ProcessException(Yii::t("app", "Data update failed"));
        }
    }
}