<?php
namespace app\models\cache;


/**
 * Class UserCacheModel 用户数据的缓存模型
 * @package app\models\cache
 */
class UserCache extends BaseCacheModel {
    /** int 用户id */
    public $id;
    /** string 登录授权码 */
    public $loginToken;
    
    /**
     * 模型规则
     * @return array
     */
    public function rules() {
        return [
            [["id", "loginToken"], "safe"]
        ];
    }
}