<?php

namespace app\models\db;

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
}
