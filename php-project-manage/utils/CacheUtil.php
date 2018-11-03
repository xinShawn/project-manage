<?php
namespace app\utils;


use Yii;

/**
 * Class CacheUtil 缓存工具
 * @package app\utils
 */
class CacheUtil {
    
    /** SESSION KEY：用户id */
    const PREFIX_USER_ID = "ui";
    
    /**
     * 设置 缓存
     * @param string $prefix 缓存前缀，用于区分类型，推荐使用 PREFIX_ 开头的常量
     * @param string $name 缓存名字
     * @param string|array $value 缓存值
     * @param int $timeoutSeconds 缓存超时：秒
     */
    public static function set($prefix, $name, $value, $timeoutSeconds = 86400) {
        $key = self::buildKey($prefix, $name);
        Yii::$app->getCache()->set($key, $value, $timeoutSeconds);
    }
    
    /**
     * 获取 缓存
     * @param string $prefix 缓存前缀，用于区分类型，推荐使用 PREFIX_ 开头的常量
     * @param string $name 缓存名字
     * @param string|array $defaultValue 默认值。当缓存中没有查询的数据时返回该值
     * @return string|array|null
     */
    public static function get($prefix, $name, $defaultValue = null) {
        $key = self::buildKey($prefix, $name);
        $value = Yii::$app->getCache()->get($key);
        
        if (empty($value)) {
            $value = $defaultValue;
        }
        
        return $value;
    }
    
    /**
     * 使用 前缀 和 缓存名字 生成 cache 的 key
     * @param string $prefix
     * @param string $name
     * @return string
     */
    private static function buildKey($prefix, $name) {
        return $prefix . "_" . $name;
    }
}