<?php
namespace app\utils;

/**
 * Class TimeUtil 时间工具
 * @package app\utils
 */
class TimeUtil {
    
    /**
     * @param int $timestamp 时间戳，单位秒
     * @return false|string
     */
    public static function timestampToTime($timestamp) {
        return date("Y-m-d H:i:s", $timestamp);
    }
}