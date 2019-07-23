<?php

namespace app\utils;


/**
 * Class DataUtil 数据处理工具
 * @package app\utils
 */
class DataUtil {
    /**
     * 使用原数组中的部分数据，组成一个  [key => value] 数组
     * @param array $array 原数组
     * @param string $keyProp 当 key 的键
     * @param string $valueProp 当 value 的键
     * @return array
     */
    public static function makeKeyValueArray(array $array, $keyProp, $valueProp) {
        $keyValueArray = [];
        
        foreach ($array as $item) {
            $keyValueArray[$item[$keyProp]] = $item[$valueProp];
        }
        return $keyValueArray;
    }
}