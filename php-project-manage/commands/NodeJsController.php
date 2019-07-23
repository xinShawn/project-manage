<?php

namespace app\commands;


use app\models\cmd\CommandOption;
use app\utils\DirUtil;

/**
 * Class NodeJsController nodejs 相关命令的封装
 * @package app\commands
 */
class NodeJsController extends BaseController {
    public $defaultAction = "dev";

    /**
     * 编译 nodejs-webpack 到 php-project-manage/web 目录下
     */
    public function actionBuild() {
        $webpackDir = DirUtil::getAbsWebPackDir();
        chdir($webpackDir);
        system("npm run build");
    }
    
    /**
     * 启动测试环境
     */
    public function actionDev() {
        $webpackDir = DirUtil::getAbsWebPackDir();
        chdir($webpackDir);
        system("npm run dev");
    }
}