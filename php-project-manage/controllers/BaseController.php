<?php

namespace app\controllers;


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
}