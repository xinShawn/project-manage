<?php

namespace app\models\db;

use app\models\form\MissionDetailForm;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "mission".
 *
 * @property int $id [int(10) unsigned]
 * @property int $priority_id [int(11) unsigned]  优先级id
 * @property string $title [varchar(255)]  任务标题
 * @property string $content 任务详情
 * @property bool $status [tinyint(3)]  任务状态。0:未开始 10:进行中 20:暂停 30:已完成 40:已关闭 -10:已取消
 * @property int $end_time [int(11) unsigned]  截止时间戳
 * @property int $finish_user_id [int(11) unsigned]  完成人id
 * @property int $create_user_id [int(11) unsigned]  创建人id
 * @property int $last_user_id [int(11) unsigned]  上次修改人id
 * @property int $update_time [int(11) unsigned]  上次更新的时间戳
 * @property int $create_time [int(11) unsigned]  创建时间
 */
class Mission extends BaseDBModel {
    
    /**
     * 状态：未开始
     */
    const STATUS_NOT_START = 0;
    /**
     * 状态：进行中
     */
    const STATUS_START = 10;
    /**
     * 状态：暂停
     */
    const STATUS_PAUSE = 20;
    /**
     * 状态：已完成
     */
    const STATUS_FINISHED = 30;
    /**
     * 状态：已关闭
     */
    const STATUS_CLOSED = 40;
    /**
     * 状态：已取消
     */
    const STATUS_CANCELED = -10;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'mission';
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['priority_id', 'title', 'content', 'create_user_id', 'last_user_id', 'update_time', 'create_time'], 'required'],
            [['priority_id', 'status', 'end_time', 'finish_user_id', 'create_user_id', 'last_user_id', 'update_time', 'create_time'], 'integer'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'priority_id' => 'Priority ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'end_time' => 'End Time',
            'finish_user_id' => 'Finish User ID',
            'create_user_id' => 'Create User ID',
            'last_user_id' => 'Last User ID',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
    
    /**
     * @param array $values
     * @param bool $safeOnly
     */
    public function setAttributes($values, $safeOnly = true) {
        if (!is_numeric($values["end_time"])) {
            $values["end_time"] = strtotime($values["end_time"]);
        }
        parent::setAttributes($values, $safeOnly);
    }
    
    /**
     * 获取任务表格数据
     * @param string $radio 快速查询选项
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function getTable($radio, $offset, $limit) {
        $query = Mission::find()->asArray()->select([
            "mission.id             AS id",
            "mission.priority_id    AS priority_id",
            "cfg_priority.name      AS priority_name",
            "mission.title          AS title",
            "mission.status         AS status",
            "mission.end_time       AS end_time",
        ])->leftJoin("cfg_priority", "cfg_priority.id = mission.priority_id");
    
        if (!empty($radio)) {
            self::setQueryMissionRadio($query, $radio);
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
    private static function setQueryMissionRadio(ActiveQuery &$query, $radio) {
        switch ($radio) {
            case "all":
                break;
            case "unfinished":
                $query->andWhere("mission.status < :status", [":status" => Mission::STATUS_FINISHED]);
                break;
        }
    }
    
    /**
     * 获取任务详情
     * @param int $id 任务id
     * @return MissionDetailForm
     */
    public static function getDetail($id) {
        $missionDetail = Mission::find()->asArray()->select([
            "mission.id             AS id",
            "mission.title          AS title",
            "mission.content        AS content",
            "mission.priority_id    AS priority_id",
            "mission.end_time       AS end_time",
        ])->where(["mission.id" => $id])->one();
        
        $missionDetailForm = new MissionDetailForm();
        $missionDetailForm->setAttributes($missionDetail);
        
        return $missionDetailForm;
    }
    
    /**
     * @return array [状态值 => 状态名字]
     */
    public static function getStatusOptions() {
        return [
            self::STATUS_NOT_START  => Yii::t("app", "not start"),
            self::STATUS_START      => Yii::t("app", "underway"),
            self::STATUS_PAUSE      => Yii::t("app", "pause"),
            self::STATUS_FINISHED   => Yii::t("app", "finished"),
            self::STATUS_CLOSED     => Yii::t("app", "closed"),
            self::STATUS_CANCELED   => Yii::t("app", "canceled")
        ];
    }
    
    
}
