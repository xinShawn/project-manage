<?php
namespace app\utils;


use Yii;

/**
 * Class SessionUtil session 工具
 * @package app\utils
 */
class SessionUtil {
    
    /**
     * SESSION KEY：用户id
     */
    const KEY_USER_ID = "ui";
    
    /**
     * 设置 session 值
     * @param string $key session 键
     * @param string|array $value session 值
     */
    public static function set($key, $value) {
        Yii::$app->getSession()->set($key, $value);
    }
    
    /**
     * 获取 session 值
     * @param string $key session 健
     * @param string|array $defaultValue 如果没有这个session时，返回的默认值
     * @return string|array|null
     */
    public static function get($key, $defaultValue = null) {
        return Yii::$app->getSession()->get($key, $defaultValue);
    }
    
    /**
     * 删除某个key
     * @param $key
     */
    public static function delete($key) {
        Yii::$app->getSession()->remove($key);
    }
    
    /**
     * 销毁 session
     */
    public static function destroy() {
        Yii::$app->getSession()->destroy();
    }
}