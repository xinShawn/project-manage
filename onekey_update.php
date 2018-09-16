#!/usr/bin/env php
<?php
/**
 * 一键更新脚本
 */

// 更新远端仓库
chdir(__DIR__);
system("git pull");

// webpack打包
chdir(__DIR__ . "/nodejs-webpack");
system("npm run build");

// 更新php数据库
chdir(__DIR__ . "/php-project-manage");
system("./yii migrate/up");