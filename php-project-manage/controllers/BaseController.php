<?php

namespace app\controllers;


use yii\web\Controller;

/**
 * Class BaseController 所有 web 控制器的基类
 * @package app\controllers
 */
class BaseController extends Controller {

    /**
     * 前端单页面应用
     * @return bool|string
     */
    public function actionIndex() {
        return $this->redirect("@web/index.html");
    }
}