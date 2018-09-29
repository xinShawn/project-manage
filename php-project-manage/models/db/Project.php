<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name 项目名称
 * @property int $status 状态
 * @property string $remark 备注
 * @property int $last_user_id 上次修改人id
 * @property int $update_time 上次修改时间
 * @property int $create_time 创建时间
 */
class Project extends BaseDBModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'status', 'remark', 'last_user_id', 'update_time', 'create_time'], 'required'],
            [['status', 'last_user_id', 'update_time', 'create_time'], 'integer'],
            [['remark'], 'string'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'remark' => 'Remark',
            'last_user_id' => 'Last User ID',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}
