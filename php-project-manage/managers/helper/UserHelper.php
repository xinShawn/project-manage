<?php
namespace app\managers\helper;

use app\models\cache\UserCache;
use app\models\db\SysUser;
use app\utils\CacheUtil;
use app\utils\SessionUtil;

/**
 * Class UserHelper userManager 的帮助类，用于封装比较零散的方法
 * @package app\managers\helper
 */
class UserHelper {
    /**
     * @return int 当前登录用户的id
     */
    public function getSessionUserId() {
        return (int) SessionUtil::get(SessionUtil::KEY_USER_ID, null);
    }
    
    /**
     * @return null
     */
    public function getLoginToken() {
        $userId = $this->getSessionUserId();
        if ($userId === null) {
            return null;
        }
        $cacheArray = CacheUtil::get(CacheUtil::PREFIX_USER_ID, $userId, []);
        $userCacheModel = new UserCache();
        $userCacheModel->setAttributes($cacheArray);
    
        return !empty($userCacheModel->loginToken) ? $userCacheModel->loginToken : null;
    }
    
    /**
     * @param SysUser $userModel
     * @return string 授权码
     */
    public function createAuthCode($userModel) {
        return hash("sha256", time() . $userModel->account);
    }
}