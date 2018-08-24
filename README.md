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

## 项目初始化

### 1 初始化 php-project-manage (yii) 项目

    #进入项目路径
    cd ./php-project-manage
    #安装 yii 的依赖库
    composer install 或 composer update
    
### 2 初始化环境配置

    执行命令。这个命令非 yii 自带
    php init
    
### 3 修改数据库配置

>文件路径：`php-project-manage/config/db-local.php`

>默认：使用mysql本地默认端口（3306）

    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=数据库名字',
    'username' => '数据库账号',
    'password' => '数据库密码',
    'charset' => 'utf8mb4',

### 4 升级更新数据库

    执行命令
    yii migrate/up 或 php yii migrate/up
    

#
#    

## 目录结构

```
/                           项目根路径
    /nodejs-webpack         nodejs 控件源码目录
    /php-project-manage     php yii 框架跟路径
        /assets             资源路径（这个可能用不到）
        /commands           命令行控制器。可以在命令行调用框架内的方法
        /config             配置文件路径
        /controllers        web 控制器
        /mail               
        /migrations         数据库版本管理文件
        /models             数据模型文件
            /db             每个数据表对应的模型
        /runtime            项目运行时产生的文件
        /tests              测试文件路径
        /vagrant            信息服务器配置参考
        /views              网页模板（html模板）
            /layouts        主模板（为模板提供父级模板） -- 日后将减少这一层的使用
            /*              每个控制器的模板。如 /controllers/SiteController 对应 site 文件夹
        /web                web 开放目录，一般存放 css、js、图片 等静态资源
        /widgets
```


#
#

## yii 框架相关命令

`提示：yii 是一个php脚本，'yii' 命令等价于 'php yii' 命令`

### 启动服务（免信息服务器）

    ./yii serve --port=8888
    
### 数据库命令

>创建数据库更新文件

    ./yii migrate/create [文件名]
    
>更新数据库

    ./yii migrate/up
    
>数据库版本回滚一个版本（前提：最近一次更新的文件支持回滚）

    ./yii migrate/down
    
###执行脚本控制器

    ./yii site/index        #等价于执行方法 /commands/SiteController::actionIndex()
    
#
#    
    
## 相关文档

>yii 文档： https://www.yiiframework.com/doc/api/2.0