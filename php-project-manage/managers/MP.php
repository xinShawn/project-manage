<?php
namespace app\managers;


/**
 * Class MP 所有 manager 的代理类
 * @package app\managers
 */
class MP {
    /**
     * @return UserManager
     */
    public static function getUserManager() {
        return UserManager::getInstance();
    }
    
    /**
     * @return MissionManager
     */
    public static function getMissionManager() {
        return MissionManager::getInstance();
    }
    
    /**
     * @return ProjectManager
     */
    public static function getProjectManager() {
        return ProjectManager::getInstance();
    }
}