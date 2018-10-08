<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2018/9/27
 * Time: 7:40
 */

namespace app\commands;

use app\utils\DirUtil;

/**
 * Class MaintainController 运维控制器
 * @package app\commands
 */
class MaintainController extends BaseController {
    public $defaultAction = "build";
    
    /**
     * 一键更新
     */
    public function actionBuild() {
        $PROJECT_MANAGE_DIR = DirUtil::getProjectManageDir();
        
        // 更新远端仓库
        chdir($PROJECT_MANAGE_DIR);
        system("git pull");

        // webpack打包
        chdir($PROJECT_MANAGE_DIR . "nodejs-webpack");
        system("npm run build");

        // 更新php数据库
        chdir($PROJECT_MANAGE_DIR . "php-project-manage");
        system("./yii migrate/up --interactive=0");
    }
}