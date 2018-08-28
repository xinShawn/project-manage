<?php
namespace app\managers;


/**
 * Class MM 所有 manager 的代理类（）
 * @package app\managers
 */
class MP {
    /**
     * @return UserManager
     */
    public static function getUserManager() {
        return UserManager::getInstance();
    }
}