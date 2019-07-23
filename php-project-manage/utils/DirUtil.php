<?php

namespace app\utils;


/**
 * Class DirUtil 路径工具
 * @package app\utils
 */
class DirUtil {

    /**
     * @return string nodejs-webpack 的绝对路径
     */
    public static function getAbsWebPackDir() {
        return dirname(dirname(__DIR__)) . "/nodejs-webpack";
    }
    
    /**
     * @return string
     */
    public static function getProjectManageDir() {
        return dirname(dirname(__DIR__)) . "/";
    }
}