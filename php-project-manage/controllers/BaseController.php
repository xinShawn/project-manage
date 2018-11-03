<?php

namespace app\controllers;

use app\exceptions\ReLoginException;
use app\managers\MP;
use Yii;
use yii\base\Action;
use yii\web\Controller;

/**
 * Class BaseController 所有 web 控制器的基类
 * @package app\controllers
 */
abstract class BaseController extends Controller {
    
    /**
     * @param Action $action
     * @return bool
     * @throws \Throwable
     * @throws \app\exceptions\ProcessException
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
        if (!MP::getUserManager()->isLogin() && !$this->isSkipLoginCheck($action)) {
            throw new ReLoginException(Yii::t("app", "not login"));
        }
        return parent::beforeAction($action);
    }
    
    /**
     * 获取 post 值
     * @param string $name 参数名字
     * @param string|array|null $defaultValue 默认值
     * @return array|string|null
     */
    public function post($name, $defaultValue = null) {
        return Yii::$app->getRequest()->post($name, $defaultValue);
    }
    
    /**
     * 获取 get 参数
     * @param string $name 参数名字
     * @param string|array|null $defaultValue 默认值
     * @return array|string|null
     */
    public function get($name, $defaultValue = null) {
        return Yii::$app->getRequest()->post($name, $defaultValue);
    }
    
    /**
     * 判断是否是不需要进行登录判断的路由
     * @param Action $action
     * @return bool
     */
    private function isSkipLoginCheck($action) {
        $skipRouteKey = [
            "user/is-init-system" => "",
            "user/init-admin-user" => "",
            "user/check-login" => "",
            "user/login" => "",
        ];
        
        if (isset($skipRouteKey[$action->getUniqueId()])) {
            return true;
        }
        return false;
    }
}