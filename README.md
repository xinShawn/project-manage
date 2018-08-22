#项目管理系统

## 项目所需环境
    nodejs  8.11 或以上
    php     7.2.7 或以上
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
    
### 2 数据库配置

    文件路径：`php-project-manage/.env` (如果文件不存在，则复制 .env.example 为 .env)
    修改如下几项
    
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=project_manage
    DB_USERNAME=test
    DB_PASSWORD=123456
    
### 3 升级数据库

    执行命令
    php artisan migrate
    
    
## 目录结构

```
/                           项目根路径
    nodejs-webpack/         nodejs 控件源码目录
    php-project-manage/     php项目路径（laravel框架）
        app/
        bootstrap/
        config/
        database/
        public/             web开放目录
        resources/
        routes/             url路由
        storage/
        tests/
        vendor/             composer包存档目录
```


#
#

## laravel 框架相关命令

##### 启动本地服务器（这种执行类似于 nodejs 无需信息服务器，方便调试）
    php artisan serve
    
##### 数据库相关命令
    创建更新日志
    php artisan make:migration [文件名] 
    
    更新数据库
    php artisan migrate
    
    版本回滚
    php artisan migrate:rollback
    
    创建 IDE-HELPER 文件(NetBeans、PHPStrom 有效)
    php artisan ide-helper：generate