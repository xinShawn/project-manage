<?php

namespace app\models\db;

use app\utils\DataUtil;

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
     * 状态：未开始
     */
    const STATUS_NOT_START = 0;
    /**
     * 状态：进行中
     */
    const STATUS_UNDERWAY = 1;
    
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
    
    /**
     * 获取表格数据
     * @return array
     */
    public static function getTable() {
        $query = self::find()->asArray()->select([
            "project.id         AS id",
            "project.name       AS name",
            "project.remark     AS remark",
        ]);
        
        return $query->all();
    }
    
    /**
     * @return array [项目id => 项目名字]
     */
    public static function getOptions() {
        $data = self::find()->asArray()->select(["id", "name"])->all();
        
        return DataUtil::makeKeyValueArray($data, "id", "name");
    }
}
