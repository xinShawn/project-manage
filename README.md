#项目管理系统

## 项目所需环境
    nodejs  8.11 或以上
    php     7.2 或以上
    mysql   5.6 或以上
    nginx|apache    (信息服务器)
    composer        (php包管理工具，类似于 nodejs 的 npm)
    
## 软件安装部分说明

### Composer 安装

#### 1 下载 composer 。 按顺序执行下面三条命令
>参考链接： `https://www.phpcomposer.com/`

>如果没有安装 git 命令的，需要先安装 git 命令

    php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"
    
执行后，本地会有一个 `composer.phar` 文件

#### 2 把 `composer.phar` 配置成全局命令 `composer` 。步骤如下：

##### windows

2.1 把 composer.phar 移动到和 php.exe 同级的目录（即：php可执行文件的路径）
        
2.2 编写脚本 composer.bat
>@php "%~dp0composer.phar" %*

#
#
#

## 项目初始化(未完善)

### 1 初始化 php-project-manage (laravel) 项目

    执行命令
    cd ./php-project-manage
    composer install
    
## 目录结构

```
/                           项目根路径
    nodejs-webpack/         nodejs 控件源码目录
```