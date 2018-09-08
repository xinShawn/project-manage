<?php

namespace app\models\db;

/**
 * This is the model class for table "cfg_priority".
 *
 * @property int $id [int(10) unsigned]
 * @property string $name [varchar(4)]  优先级名称：如：高级、中级、低级
 * @property bool $order [tinyint(3) unsigned]  排序优先级。越小越优先
 * @property int $last_user_id [int(11) unsigned]  上次修改人id
 * @property int $update_time [int(11) unsigned]  上次更新的时间戳
 * @property int $create_time [int(11) unsigned]  创建时间
 */
class CfgPriority extends BaseDBModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cfg_priority';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'order', 'last_user_id', 'update_time', 'create_time'], 'required'],
            [['order', 'last_user_id', 'update_time', 'create_time'], 'integer'],
            [['name'], 'string', 'max' => 4],
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
            'order' => 'Order',
            'last_user_id' => 'Last User ID',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }
}
