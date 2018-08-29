<?php

namespace app\controllers;


use app\managers\MP;
use app\models\ApiReturn;
use Yii;

/**
 * Class UserController 用户控制器
 * @package app\controllers
 */
class UserController extends BaseController {
    
    /**
     * 是否已经初始化了管理员账号
     */
    public function actionIsInitAdminUser() {
        $isInitAdmin = MP::getUserManager()->isInitAdmin();
        
        return ApiReturn::retSucc(["isInitAdmin" => $isInitAdmin]);
    }
    
    /**
     * 初始化系统管理员账号
     * @throws \Throwable
     */
    public function actionInitAdminUser() {
        $account = Yii::$app->request->post("account");
        $password = Yii::$app->request->post("password");
        
        if (empty($account) || empty($password)) {
            return ApiReturn::retFailEmptyData(["account" => $account, "password" => $password]);
        }
        
        if (strlen($password) !== 32) {
            return ApiReturn::ret(ApiReturn::FAIL_ILLEGAL_DATA, "the password must be encrypted with MD5");
        }
        
        $userManager = MP::getUserManager();
        
        if ($userManager->isInitAdmin()) {
            return ApiReturn::ret(ApiReturn::FAIL_ALREADY_INIT);
        }
    
        $userManager->addUser(0, $account, $password, "系统管理员");
        
        return ApiReturn::retSucc();
    }
}