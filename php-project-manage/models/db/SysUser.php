<?php

namespace app\models\db;

use app\models\TableModel;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "sys_user".
 * @property int $id [int(10) unsigned]
 * @property int $group_id [int(11) unsigned]  组id
 * @property string $account [varchar(32)]  登录账号
 * @property string $password [char(32)]  登录密码的md5值
 * @property string $real_name [varchar(20)]  真实姓名
 * @property string $nickname [varchar(20)]  用户昵称
 * @property string $language [varchar(8)]  语言。如：zh-CN,en-US
 * @property string $auth_code [varchar(64)]  登录授权码。cookie 保存，用于快速登录
 * @property int $auth_code_dead_time [int(11) unsigned]  登录授权码有效期
 * @property string $last_login_ip [varchar(24)]  上次登录id
 * @property int $last_login_time [int(11) unsigned]  上次登录时间
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
    public function rules()
    {
        return [
            [['group_id', 'account', 'password', 'create_time'], 'required'],
            [['group_id', 'auth_code_dead_time', 'last_login_time', 'create_time'], 'integer'],
            [['account', 'password'], 'string', 'max' => 32],
            [['real_name', 'nickname'], 'string', 'max' => 20],
            [['language'], 'string', 'max' => 8],
            [['auth_code'], 'string', 'max' => 64],
            [['last_login_ip'], 'string', 'max' => 24],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'account' => 'Account',
            'password' => 'Password',
            'real_name' => 'Real Name',
            'nickname' => 'Nickname',
            'language' => 'Language',
            'auth_code' => 'Auth Code',
            'auth_code_dead_time' => 'Auth Code Dead Time',
            'last_login_ip' => 'Last Login Ip',
            'last_login_time' => 'Last Login Time',
            'create_time' => 'Create Time',
        ];
    }
    
    /**
     * 使用账号搜索模型
     * @param string $account 账号
     * @return SysUser|null
     */
    public static function findByAccount($account) {
        return self::findOne(["account" => $account]);
    }
    
    /**
     * 获取用户表格数据
     */
    public static function getUserTable() {
        $query = new Query();
        $query->select([
            "sys_user.id                AS id",
            "sys_user.nickname          AS nickname",
            "sys_user.real_name         AS real_name",
            "sys_user.account           AS account",
            "sys_user.language          AS language",
            "sys_user.last_login_time   AS last_login_time",
            "sys_user.last_login_ip     AS last_login_ip"
        ])->from("sys_user");
        
        $query->orderBy(["sys_user.id" => SORT_ASC]);
        $count = $query->count();
        $rows = $query->all();
        
        return TableModel::newInstance($rows, $count)->toArray();
    }
}
