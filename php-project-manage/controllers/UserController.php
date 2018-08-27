<?php

namespace app\controllers;


use app\managers\MM;
use app\models\ApiReturn;

/**
 * Class UserController 用户控制器
 * @package app\controllers
 */
class UserController extends BaseController {
    
    /**
     * 是否已经初始化了管理员账号
     */
    public function actionIsInitAdminUser() {
        $isInitAdmin = MM::getUserManager()->isInitAdmin();
        
        return ApiReturn::retSucc(["isInitAdmin" => $isInitAdmin]);
    }
}