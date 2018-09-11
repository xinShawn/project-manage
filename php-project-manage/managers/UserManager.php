<?php
namespace app\managers;


use app\exceptions\ProcessException;
use app\models\cache\UserCacheModel;
use app\models\db\SysUser;
use app\utils\CacheUtil;
use app\utils\SessionUtil;
use Yii;
use yii\db\Exception;

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
            self::$shareInstance = new static();
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
    
    /**
     * 添加用户
     * @param int $groupId 组id
     * @param string $account 账号
     * @param string $password 登录密码
     * @param string $real_name 真实姓名
     * @param string $nickname 昵称
     * @throws Exception
     * @throws \Throwable
     */
    public function addUser($groupId, $account, $password, $real_name, $nickname) {
        $user = new SysUser();
        $user->group_id = $groupId;
        $user->account = $account;
        $user->password = $password;
        $user->real_name = $real_name;
        $user->nickname = $nickname;
        $user->create_time = time();
        
        if ( $user->insert() === false ) {
            throw new Exception("insert failed!");
        }
    }
    
    /**
     * 进行登录
     * @param string $account 登录账号
     * @param string $password 登录密码
     * @return string 登录令牌
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function login($account, $password) {
        $sysUserModel = SysUser::findOne(["account" => $account]);
        
        if ($sysUserModel === null) {
            throw new ProcessException("account not exists");
        }
        
        if ($password !== $sysUserModel->password) {
            throw new ProcessException("password error");
        }
        
        $time = time();
        
        // 设置登录状态信息
        SessionUtil::set(SessionUtil::KEY_USER_ID, $sysUserModel->id);
        $loginToken = md5($account . $time);
        $userCacheModel = new UserCacheModel();
        $userCacheModel->id = $sysUserModel->id;
        $userCacheModel->loginToken = $loginToken;
        CacheUtil::set(CacheUtil::PREFIX_USER_ID, $sysUserModel->id, $userCacheModel->toArray());
        
        // 更新用户登录状态
        $sysUserModel->last_login_time = $time;
        $sysUserModel->last_login_ip = Yii::$app->getRequest()->getUserIP();
        
        $sysUserModel->update();
        
        return $loginToken;
    }
    
    /**
     * 获取当前用户的 loginToken 如果没有，则说明没有登录
     * @return string|null 登录令牌
     */
    public function getLoginToken() {
        $userId = (int) SessionUtil::get(SessionUtil::KEY_USER_ID, 0);
        $cacheArray = CacheUtil::get(CacheUtil::PREFIX_USER_ID, $userId, []);
        $userCacheModel = new UserCacheModel();
        $userCacheModel->setAttributes($cacheArray);
        
        return !empty($userCacheModel->loginToken) ? $userCacheModel->loginToken : null;
    }
    
    /**
     * 注销
     */
    public function logout() {
        SessionUtil::destroy();
    }
    
    /**
     * @return int 当前登录的用户id
     */
    public function getCurrentUserId() {
        $userId = (int) SessionUtil::get(SessionUtil::KEY_USER_ID);
        return $userId;
    }
}