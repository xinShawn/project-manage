<?php

namespace app\models\db;

use app\models\db\BaseDBModel;
use Yii;

/**
 * Class SysUser
 * @package app\models\db
 * @property int $id [int(10) unsigned]
 * @property int $group_id [int(11) unsigned]  组id
 * @property string $account [varchar(32)]  登录账号
 * @property string $password [char(32)]  登录密码的md5值
 * @property string $nickname [varchar(20)]  用户昵称
 * @property int $create_time [int(11) unsigned]  创建时间
 */
class SysUser extends BaseDBModel {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sys_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['group_id', 'account', 'password', 'create_time'], 'required'],
            [['group_id', 'create_time'], 'integer'],
            [['account', 'password'], 'string', 'max' => 32],
            [['nickname'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'account' => 'Account',
            'password' => 'Password',
            'nickname' => 'Nickname',
            'create_time' => 'Create Time',
        ];
    }
}
