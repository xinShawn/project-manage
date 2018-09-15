<?php

namespace app\commands;


use app\models\cmd\CommandOption;
use app\utils\DirUtil;

/**
 * Class NodeJsController nodejs 相关命令的封装
 * @package app\commands
 */
class NodeJsController extends BaseController {

    /**
     * 输出帮助信息
     * @return void
     * @throws BaseControllerException
     */
    public function actionHelp() {
        $this->printPrettyActionArray("node-js", [
            new CommandOption("build", "编译 nodejs-webpack 到 php-project-manage/web 目录下"),
        ]);
    }

    /**
     * 编译 nodejs-webpack 到 php-project-manage/web 目录下
     */
    public function actionBuild() {
        $webpackDir = DirUtil::getAbsWebPackDir();
        chdir($webpackDir);
        system("npm run build");
    }



}