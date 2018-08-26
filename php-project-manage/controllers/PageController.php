<?php

namespace app\controllers;

/**
 * Class PageController 页面控制器（本框架使用 vue webpack 做单页面应用，因此页面相关出处理很少）
 * @package app\controllers
 */
class PageController extends BaseController {

    /**
     * 前端单页面应用
     * @return bool|string
     */
    public function actionIndex() {
        return $this->redirect("@web/index.html");
    }
}