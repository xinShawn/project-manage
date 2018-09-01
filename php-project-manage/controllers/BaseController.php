<?php

namespace app\controllers;


use Yii;
use yii\web\Controller;

/**
 * Class BaseController 所有 web 控制器的基类
 * @package app\controllers
 */
abstract class BaseController extends Controller {
    
    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action) {
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
     * 获取 post 或 get 的参数
     * @param string $name 参数名字
     * @param string|array|null $defaultValue 默认值
     * @return array|string|null
     */
    public function param($name, $defaultValue = null) {
        $value = Yii::$app->getRequest()->post($name, $defaultValue);
        if ($value == $defaultValue) {
            $value = Yii::$app->getRequest()->post($name, $defaultValue);
        }
        return $value;
    }
}