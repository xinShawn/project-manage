<?php
namespace app\managers;

use app\constant\CONF;
use app\exceptions\ProcessException;
use app\managers\helper\UserHelper;
use app\models\cache\UserCache;
use app\models\db\SysUser;
use app\utils\CacheUtil;
use app\utils\CookieUtil;
use app\utils\SessionUtil;
use Yii;
use yii\db\Exception;

/**
 * Class UserManager 用户 manager
 * @package app\managers
 */
class UserManager extends BaseManager {
    /** @var UserManager 单利对象 */
    private static $shareInstance = null;
    /** @var UserHelper UserManager 帮助对象 */
    public $helper = null;
    private function __construct() {
        $this->helper = new UserHelper();
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
     * 获取当天登录的用户
     * @return SysUser
     */
    public function getSessionUser() {
        $userId = $this->helper->getSessionUserId();
        return SysUser::findOne($userId);
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
        $sysUser = SysUser::findOne(["account" => $account]);
        
        if ($sysUser === null) {
            throw new ProcessException(Yii::t("app", "account not exists"));
        }
        
        if ($password !== $sysUser->password) {
            throw new ProcessException(Yii::t("app", "password error"));
        }
        
        $time = time();
        
        // 设置登录状态信息
        SessionUtil::set(SessionUtil::KEY_USER_ID, $sysUser->id);
        $loginToken = md5($account . $time);
        $userCacheModel = new UserCache();
        $userCacheModel->id = $sysUser->id;
        $userCacheModel->loginToken = $loginToken;
        CacheUtil::set(CacheUtil::PREFIX_USER_ID, $sysUser->id, $userCacheModel->toArray());
        // 记录 cookie 信息，用于快速登录
        $authCode = $this->helper->createAuthCode($sysUser);
        $authCodeDeadTime = $time + CONF::USER_AUTH_CODE_ACTIVE_SECONDS;
        CookieUtil::set(CookieUtil::NAME_AUTH_CODE, $authCode, $authCodeDeadTime);
        CookieUtil::set(CookieUtil::NAME_ACCOUNT, $sysUser->account);
        $sysUser->auth_code = $authCode;
        $sysUser->auth_code_dead_time = $authCodeDeadTime;
        
        // 更新用户登录状态
        $sysUser->last_login_time = $time;
        $sysUser->last_login_ip = Yii::$app->getRequest()->getUserIP();
        
        if ($sysUser->update() === false) {
            throw new ProcessException(Yii::t("app", "failed"));
        }
        
        return $loginToken;
    }
    
    /**
     * 注销
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function logout() {
        $sysUser = $this->getSessionUser();
        if ($sysUser !== null) {
            $sysUser->auth_code_dead_time = 0;
            if ($sysUser->update() === false) {
                throw new ProcessException(Yii::t("app", "failed"));
            }
        }
        SessionUtil::destroy();
        CookieUtil::destroy();
    }
    
    /**
     * 判断是否登录
     * @return bool
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function isLogin() {
        $userId = $this->helper->getSessionUserId();
        if (empty($userId)) {
            $account = CookieUtil::get(CookieUtil::NAME_ACCOUNT);
            $authCode = CookieUtil::get(CookieUtil::NAME_AUTH_CODE);
            if (empty($account) || empty($authCode)) {
                return false;   // 没有 cookie 信息，登录无效
            }
            $sysUser = SysUser::findByAccount($account);
            if ($sysUser === null) {
                return false;   // 不存在这个用户，登录无效
            }
            // cookie 快速登录
            if ($sysUser->auth_code_dead_time > time() && $authCode === $sysUser->auth_code) {
                $this->login($sysUser->account, $sysUser->password);
            } else {
                return false;   // cookie 验证码已过期，需要重新登录
            }
            $userId = $sysUser->id;
        }
        $userCacheArray = CacheUtil::get(CacheUtil::PREFIX_USER_ID, $userId, []);
        if (empty($userCacheArray)) {
            return false;       // 缓存中信息被清除，可能被强制下线
        }
        
        return true;
    }
}