<?php

namespace app\models\db;

/**
 * This is the model class for table "rel_mission_user".
 *
 * @property int $id [int(10) unsigned]
 * @property int $mission_id [int(11) unsigned]  任务id
 * @property int $user_id [int(11) unsigned]  用户id
 */
class RelMissionUser extends BaseDBModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rel_mission_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mission_id', 'user_id'], 'required'],
            [['mission_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mission_id' => 'Mission ID',
            'user_id' => 'User ID',
        ];
    }
}
