<?php

namespace app\controllers;


use app\exceptions\ProcessException;
use app\managers\MP;
use app\models\ApiReturn;
use app\models\db\SysUser;
use Yii;

/**
 * Class UserController 用户控制器
 * @package app\controllers
 */
class UserController extends BaseController {
    
    /**
     * 获取系统是否已经初始化
     */
    public function actionIsInitSystem() {
        $isInitAdmin = "true";
        if (!MP::getUserManager()->isInitAdmin()) {
            $isInitAdmin = "false";
        }
        
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
    
        $userManager->addUser(0, $account, $password, "系统管理员", "系统管理员");
        
        return ApiReturn::retSucc();
    }
    
    /**
     * 检测是否已经登录，并返回 loginToken。如果 loginToken 为 null，则登录无效
     */
    public function actionCheckLogin() {
        $loginToken = MP::getUserManager()->getLoginToken();
        return ApiReturn::retSucc(["loginToken" => $loginToken]);
    }
    
    /**
     * 进行登录
     * @return string
     * @throws ProcessException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionLogin() {
        $account = $this->post("account");
        $password = $this->post("password");
    
        $loginToken = MP::getUserManager()->login($account, $password);
        
        return ApiReturn::retSucc(["loginToken" => $loginToken]);
    }
    
    /**
     * 进行登出
     */
    public function actionLogout() {
        MP::getUserManager()->logout();
        return ApiReturn::retSucc();
    }
    
    /**
     * 获取用户表格数据
     */
    public function actionGetUserTable() {
        $tableData = SysUser::getUserTable();
        return ApiReturn::retSucc($tableData);
    }
    
    /**
     * 添加用户
     * @throws \Throwable
     */
    public function actionAddUser() {
        $account = $this->param("account");
        $password = $this->param("password");
        $real_name = $this->param("real_name");
        $nickname = $this->param("nickname");
        
        if (empty($account) || empty($password) || empty($real_name) || empty($nickname)) {
            return ApiReturn::retFailEmptyData();
        }
        
        MP::getUserManager()->addUser(0, $account, $password, $real_name, $nickname);
        
        return ApiReturn::retSucc();
    }
}