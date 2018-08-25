<?php

namespace app\models\db;

use Yii;

/**
 * Class SysGroup
 * @package app\models\db
 * @property int $id [int(10) unsigned]
 * @property string $name [varchar(32)]  组名
 * @property int $create_time [int(11) unsigned]  创建时间
 */
class SysGroup extends BaseDBModel {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sys_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'create_time'], 'required'],
            [['create_time'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'create_time' => 'Create Time',
        ];
    }
}
