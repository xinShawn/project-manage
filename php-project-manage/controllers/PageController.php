<?php

namespace app\controllers;

use app\exceptions\ReLoginException;
use app\models\ApiReturn;
use Yii;

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
    
    /**
     * 捕捉所有 UserException ，并进行翻译处理，返回给客户端 json 消息
     */
    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            Yii::$app->response->statusCode = 200;
            if ($exception instanceof ReLoginException) {
                return ApiReturn::ret(ApiReturn::FAIL_RE_LOGIN, $exception->getMessage());
            }
            Yii::$app->response->statusCode = 200;
            return ApiReturn::retFailMessage($exception->getMessage());
        } else {
            return ApiReturn::retFailMessage(Yii::t("app", "unknown error"));
        }
    }
}