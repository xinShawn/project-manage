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
    
    /**
     * 获取任务详情
     * @param int $id 任务id
     * @return MissionDetailForm
     */
    public function getDetail($id) {
        $missionDetail = Mission::find()->asArray()->select([
            "mission.id         AS id",
            "mission.title      AS title",
            "mission.content    AS content",
        ])->where(["mission.id" => $id])->one();
        
        $missionDetailForm = new MissionDetailForm();
        $missionDetailForm->setAttributes($missionDetail);
        
        return $missionDetailForm;
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
    
    /**
     * 获取任务表格数据
     * @param string $radio 快速查询选项
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getMissionTable($radio, $offset, $limit) {
        $query = Mission::find()->asArray()->select([
            "mission.id             AS id",
            "mission.priority_id    AS priority_id",
            "cfg_priority.name      AS priority_name",
            "mission.title          AS title",
            "mission.status         AS status",
            "mission.end_time       AS end_time",
        ])->leftJoin("cfg_priority", "cfg_priority.id = mission.priority_id");
        
        if (!empty($radio)) {
            $this->setQueryMissionRadio($query, $radio);
        }
        
        $query->orderBy(["id" => SORT_ASC])->offset($offset)->limit($limit);
        
        $count = $query->count();
        $data = $query->all();
        
        $statusOptions = Mission::getStatusOptions();
        
        foreach ($data as $key => $item) {
            $data[$key]["status_name"] = $statusOptions[$item["status"]];
            $data[$key]["end_time"] = date("Y-m-d H-i-s", $item["end_time"]);
        }
        
        return [
            "count" => $count,
            "data" => $data
        ];
    }
    
    /**
     * 设置任务查询的快速选项
     * @param ActiveQuery $query
     * @param string $radio 具体查询类型
     *      all         所有
     *      unfinished  未完成
     */
    private function setQueryMissionRadio(ActiveQuery &$query, $radio) {
        switch ($radio) {
            case "all":
                break;
            case "unfinished":
                $query->andWhere("mission.status < :status", [":status" => Mission::STATUS_FINISHED]);
                break;
        }
    }
}