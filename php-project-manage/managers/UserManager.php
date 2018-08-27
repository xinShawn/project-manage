<?php
namespace app\managers;


use app\models\db\SysUser;

/**
 * Class UserManager 用户 manager
 * @package app\managers
 */
class UserManager extends BaseManager {
    private static $shareInstance = null;
    private function __construct() {
    }
    /**
     * @return UserManager
     */
    public static function getInstance() {
        if (self::$shareInstance === null) {
            self::$shareInstance = new UserManager();
        }
        return self::$shareInstance;
    }
    
    /**
     * @return bool 是否已经初始化了管理员账号
     */
    public function isInitAdmin() {
        $userCount = (int) SysUser::find()->count();
        if ($userCount === 0) {
            return false;
        }
        return true;
    }
}