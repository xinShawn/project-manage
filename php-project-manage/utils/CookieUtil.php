<?php
namespace app\utils;

use Yii;
use yii\web\Cookie;

/**
 * Class CookieUtil cookie 工具
 * @package app\utils
 */
class CookieUtil {
    /** cookie 登录授权码 */
    const NAME_AUTH_CODE = "ac";
    /** cookie 登录账号 */
    const NAME_ACCOUNT = "a";
    
    /**
     * 设置 cookie
     * @param string $name cookie 名字
     * @param string $value cookie 值
     * @param int $activeTime 有效时间。默认 30 天
     */
    public static function set($name, $value, $activeTime = 2592000) {
        $cookie = new Cookie();
        $cookie->name = $name;
        $cookie->value = $value;
        $cookie->expire = time() + $activeTime;
        Yii::$app->response->getCookies()->add($cookie);
    }
    
    /**
     * @param string $name cookie 名字
     * @param string $defaultValue 默认值
     * @return string|null
     */
    public static function get($name, $defaultValue = null) {
        return Yii::$app->request->getCookies()->getValue($name, $defaultValue);
    }
    
    /**
     * 销毁所有 cookie
     */
    public static function destroy() {
        Yii::$app->response->getCookies()->removeAll();
    }
}